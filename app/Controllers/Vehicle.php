<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\VehicleModel;
use App\Models\OrganizationModel;
use App\Models\WareHouseModel;

class Vehicle extends BaseController
{
    protected VehicleModel $vehicle;
    protected organizationModel $organization;
    protected WareHouseModel $warehouse;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->vehicle = new VehicleModel();
        $this->organization = new OrganizationModel();
        $this->warehouse = new WareHouseModel();
    }

    public function index()
    {
        $data['title'] = 'Vehicle';

        return view('vehicle/index', $data);
    }

    public function create()
    {
        $dataWarehouse = $this->warehouse->dataWarehouse();

        $dataOrganization = $this->db->table('organization_program a')
            ->select('b.organization_id, a.organization_program_id, d.organization_type_id, b.organization_name')
            ->join('organization b', 'a.organization_id = b.organization_id')
            ->join('program c', 'a.program_id = c.program_id')
            ->join('organization_type d', 'a.organization_type_id = d.organization_type_id')
            ->get()->getResultArray();

       $data = [
            'title' => 'Vehicle',
            'organization' => $dataOrganization,
            'warehouse' => $dataWarehouse
        ];

        return view('vehicle/create', $data);
    }

    public function save()
    {
        // var_dump($this->request->getPost());exit;
        $rules = [
            'organization_program_id' => [
                'rules' => 'permit_empty|exclusiveRequired[organization_program_id,warehouse_id]',
            ],

            'warehouse_id' => [
                'rules' => 'permit_empty',
            ],

            'organization_program_id' => [ // atau bisa ditaruh di salah satu field
                'rules' => 'permit_empty|integer|callback_check_exclusive[warehouse_id]',
            ],

            'plate_number' => [
                'rules'  => 'required|is_unique[vehicle.plate_number]',
                'errors' => [
                    'required'  => 'License plate number is required',
                    'is_unique' => 'Police number is already in use'
                ]
            ],
            'vehicle_type' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Vehicle type is required'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status is required to be selected'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $this->vehicle->insert([
            'organization_program_id'=> $this->request->getPost('organization_program_id') ? : null,
            'warehouse_id'           => $this->request->getPost('warehouse_id') ? : null,
            'plate_number'           => strtoupper($this->request->getPost('plate_number')),
            'vehicle_type'           => $this->request->getPost('vehicle_type'),
            'capacity_weight'        => $this->request->getPost('capacity_weight'),
            'capacity_volume'        => $this->request->getPost('capacity_volume'),
            'brand'                  => $this->request->getPost('brand'),
            'stnk_expiry_date'       => $this->request->getPost('stnk_expiry_date'),
            'kir_expiry_date'        => $this->request->getPost('kir_expiry_date'),
            'status'                 => $this->request->getPost('status'),
            'created_date'           => date('Y-m-d H:i:s'),
            'modified_date'          => date('Y-m-d H:i:s'),
            'created_by'             => session()->get('users_id')
        ]);

        return $this->response->setJSON([
            'status'   => true,
            'message'  => 'Data kendaraan berhasil disimpan',
            'redirect' => base_url('Vehicle')
        ]);
    
    }

    public function datatables()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $program_id = session()->get('program');

        $baseQuery = "
            FROM vehicle a
            LEFT JOIN organization_program b
                ON a.organization_program_id = b.organization_program_id
            LEFT JOIN program c
                ON b.program_id = c.program_id
            LEFT JOIN organization d
                ON b.organization_id = d.organization_id
            LEFT JOIN warehouse w 
                ON a.warehouse_id = w.warehouse_id
            WHERE COALESCE(b.program_id, w.program_id) = ?
        ";

        $filter = "";
        $params = [$program_id];

        if (!empty($search)) {

            $filter .= "
                AND (
                    d.organization_name LIKE ?
                    OR a.plate_number LIKE ?
                    OR a.vehicle_type LIKE ?
                    OR a.brand LIKE ?
                    OR a.capacity_weight LIKE ?
                    OR a.status LIKE ?
                )
            ";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $totalRecords = $this->db
            ->query("SELECT COUNT(*) cnt {$baseQuery}",[$program_id])
            ->getRow()
            ->cnt;

        $totalFiltered = $totalRecords;

        if (!empty($search)) {

            $totalFiltered = $this->db
                ->query(
                    "SELECT COUNT(*) cnt {$baseQuery} {$filter}",
                    $params
                )
                ->getRow()
                ->cnt;
        }

        $orderColumn = [
            'd.organization_name',
            'w.warehouse_name',
            'a.plate_number',
            'a.vehicle_type',
            'a.brand',
            'a.capacity_weight',
            'a.status',
            'a.created_date'
        ];

        $orderDirection =
            $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy =
            $orderColumn[
                $request->getPost('order')[0]['column'] ?? 6
            ];

        $sql = "
            SELECT
                a.*,
                d.organization_name,
                c.name AS program_name,
                w.warehouse_name
            {$baseQuery}
            {$filter}
            ORDER BY {$orderBy} {$orderDirection}
            LIMIT ?, ?
        ";

        $params[] = (int)$start;
        $params[] = (int)$length;

        $query = $this->db->query($sql, $params);

        $data = [];

        foreach ($query->getResultArray() as $row) {

            if ($row['status'] == 'available') {

                $row['status_badge'] =
                    '<span class="badge badge-success">Available</span>';

            } elseif ($row['status'] == 'on_delivery') {

                $row['status_badge'] =
                    '<span class="badge badge-primary">On Delivery</span>';

            } else {

                $row['status_badge'] =
                    '<span class="badge badge-danger">Maintenance</span>';
            }

            $row['action'] = '

                <a href="javascript:void(0);"
                class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail" data-id="'.$row['vehicle_id'].'"
                data-original-title="View">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="'.base_url().'Vehicle/edit/'.$row['vehicle_id'].'"
                class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1"  data-toggle="tooltip" data-original-title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>
            ';

            $data[] = $row;
        }

        return $this->response->setJSON([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }

    public function detail($id)
    {
        $views = $this->vehicle->getDataVehicle($id);
        // var_dump($views);exit;
        $data = [
            'title' => 'Vehicle Detail',
            'views' => $views,
        ];

        return view(
            'vehicle/detail', $data
        );
    }

    public function edit($id)
    {
        $dataOrganization = $this->organization->getDataOrg();
        $dataWarehouse = $this->warehouse->dataWarehouse(); 
        $datavehicle = $this->vehicle->getDataVehicle($id);
        // var_dump($datavehicle);exit;
        $data = [
            'title' => 'Vehicle Detail',
            'vehicle' => $datavehicle,
            'organization' => $dataOrganization,
            'warehouse' => $dataWarehouse
        ];

        return view(
            'vehicle/edit', $data
        );
    }

    public function saveedit($id)
    { 
        $rules = [
            'organization_program_id' => [
                'rules' => 'permit_empty|exclusiveRequired[organization_program_id,warehouse_id]',
            ],

            'warehouse_id' => [
                'rules' => 'permit_empty',
            ],

            'plate_number' => [
                'rules'  => 'required',
                'errors' => [
                    'required'  => 'License plate number is required',
                ]
            ],
            'vehicle_type' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Vehicle type is required'
                ]
            ],
            'status' => [
                'rules'  => 'required',
                'errors' => [
                    'required' => 'Status is required to be selected'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $db = db_connect();
        $db->transBegin();
        try {

            $vehicle = $this->vehicle->find($id);
            
            if (!$vehicle) {
                throw new \Exception('vehicle not found.');
            }
            
            $fields = [
                'organization_program_id',
                'warehouse_id',
                'plate_number',
                'vehicle_type',
                'brand',
                'capacity_weight',
                'capacity_volume',
                'stnk_expiry_date',
                'kir_expiry_date',
                'status',
            ];

            $updateData = [];
            foreach ($fields as $field) {

                $newValue = $this->request->getPost($field);
                // var_dump($newValue);exit;
                if ((string)$vehicle[$field] !== (string)$newValue) {
                    $updateData[$field] = $newValue;
                }
            }

            if (!empty($updateData)) {

                $updateData['modified_by'] = session()->get('user_id');

                $this->vehicle->update($id, $updateData);
            }

            $db->transCommit();

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Company successfully updated.'
            ]);

        } catch (\Throwable $e) {
            
           $db->transRollback();

            throw $e;
        }

    }
}