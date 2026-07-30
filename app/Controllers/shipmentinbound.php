<?php

/** Controller Shipment untuk proses Shipment Collection  */

namespace App\Controllers;

use App\Models\ShipmentModel;
use App\Models\DriverModel;
use App\Models\VehicleModel;
use App\Models\PurchaseOrderModel;
use App\Models\StatusModel;
use App\Models\OrganizationModel;
use App\Models\ShipmentDetailModel;

class ShipmentInbound extends BaseController
{
    protected ShipmentModel $shipment;
    protected OrganizationModel $organizationModel;
    protected ShipmentDetailModel $shipmentDetail;

    protected $columnSearch;
    protected $columnOrder;
    protected $order;
    protected $table;

    public function __construct()
    {
        $session = \Config\Services::session();
		if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->shipment = new ShipmentModel();
        $this->organizationModel = new OrganizationModel();
        $this->shipmentDetail = new ShipmentDetailModel();
    }

    public function index()
    {
        $data['title'] = 'Shipment Inbound';

        return view('shipment/inbound/inbound', $data);
    }

    public function Create()
    {
        $supplier = $this->organizationModel->getTypeOrg('Supplier');
        $buyer   = $this->organizationModel->getTypeOrg('Buyer');

        $vehicle  = (new VehicleModel())->findAll();
        // $data['po'] = (new PurchaseOrderModel())->findAll();
        
        $status = (new StatusModel())->where('module', 'SHIPMENT')->findAll();

        $dataDriver = $this->db->table('driver')->get()->getResultArray();

        $data = [
            'driver' => $dataDriver,
            'status' => $status,
            'supplier' => $supplier,
            'buyer' => $buyer,
            'vehicle' =>  $vehicle
        ];

        return view('shipment/inbound/create', $data);
    }

    public function savecreate()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'shipment_number' => [
                'label' => 'Shipment Number',
                'rules' => 'required|is_unique[shipment.shipment_number]'
            ],
            'supplier_id' => [
                'label' => 'Supplier',
                'rules' => 'required'
            ],
            'buyer_id' => [
                'label' => 'Buyer',
                'rules' => 'required'
            ],
            'driver_id' => [
                'label' => 'Driver',
                'rules' => 'required'
            ],
            'vehicle_id' => [
                'label' => 'Vehicle',
                'rules' => 'required'
            ]
        ];

        if (!$validation->setRules($rules)->run($this->request->getPost())) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $validation->getErrors()
            ]);
        }

        $db = \Config\Database::connect();
        $db->transBegin();

        try {

            $shipmentNumber = $this->shipment->generateShipmentNumber();

            // ==========================
            // Save Shipment Header
            // ==========================
            $this->shipment->insert([
                'shipment_number'   => $shipmentNumber,
                'purchase_order_id' => $this->request->getPost('purchase_order_id'),
                'shipment_type'     => 'INBOUND',
                'driver_id'         => $this->request->getPost('driver_id'),
                'vehicle_id'        => $this->request->getPost('vehicle_id'),
                'departure_at'      => $this->request->getPost('departure_at'),
                'arrival_at'        => $this->request->getPost('arrival_at'),
                'status_id'         => 11,
                'created_by'        => session()->get('users_id')
            ]);

            $shipmentId = $this->shipment->getInsertID();

            // ==========================
            // Save Shipment Detail
            // ==========================

            $detail = [
                [
                    'shipment_id'            => $shipmentId,
                    'sequence_no'            => 1,
                    'activity_type'          => 'PICKUP',
                    'organization_program_id'=> $this->request->getPost('supplier_id'),
                    'departure_at'           => $this->request->getPost('departure_at'),
                    'arrival_at'             => null,
                    'qty'                    => null,
                    'unit'                   => null,
                    'status_id'              => 11,
                    'note'                   => null,
                    'created_by'             => session()->get('users_id'),
                ],
            ];

            $shipmentDetailModel = new \App\Models\ShipmentDetailModel();
            $shipmentDetailModel->insertBatch($detail);

            if ($db->transStatus() === false) {
                throw new \Exception('Failed to save shipment.');
            }

            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Shipment successfully created.'
            ]);

        } catch (\Throwable $e) {

            $db->transRollback();

            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
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
            FROM shipment a
            LEFT JOIN driver b
                ON a.driver_id = b.driver_id
            LEFT JOIN vehicle c
                ON a.vehicle_id = c.vehicle_id
            LEFT JOIN status d
                ON a.status_id = d.status_id
            LEFT JOIN shipment_detail e
                ON a.shipment_id = e.shipment_id
            JOIN organization_program op 
                ON e.organization_program_id = op.organization_program_id
            JOIN program p
                ON op.program_id = p.program_id
            JOIN organization o
                ON op.organization_id = o.organization_id
            WHERE shipment_type = 'INBOUND' AND op.program_id = ?
        ";

        $filter = "";
        $params = [$program_id];

        if (!empty($search)) {

            $filter .= "
                AND (
                    a.shipment_number LIKE ?
                    OR b.driver_name LIKE ?
                    OR c.plate_number LIKE ?
                    OR d.status_name LIKE ?
                    OR a.created_date LIKE ?
                )
            ";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $totalRecords = $this->db
            ->query("
                SELECT COUNT(DISTINCT a.shipment_id) cnt
                {$baseQuery}", [$program_id])->getRow()->cnt;

        $totalFiltered = $totalRecords;

        if (!empty($search)) {
            $totalFiltered = $this->db
                ->query(
                    "
                    SELECT COUNT(DISTINCT a.shipment_id) cnt
                    {$baseQuery} {$filter}
                    ", $params
                )
                ->getRow()
                ->cnt;
        }

        $orderColumn = [
            'a.shipment_number',
            'b.driver_name',
            'c.plate_number',
            'd.status_name',
            'a.created_date'
        ];

        $orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy =
            $orderColumn[
                $request->getPost('order')[0]['column'] ?? 3
            ];

        $sql = "
            SELECT
                a.*,
                b.driver_name,
                c.plate_number,
                d.status_code,
                d.status_name,
                COUNT(e.shipment_detail_id) AS total_stop
            {$baseQuery}
            {$filter}
            GROUP BY
                a.shipment_id
            ORDER BY
                {$orderBy} {$orderDirection}
            LIMIT ?, ?
            ";

        $params[] = (int)$start;
        $params[] = (int)$length;

        $query = $this->db->query($sql, $params);

        $data = [];

        foreach ($query->getResultArray() as $row) {
            switch ($row['status_code']) {
                case 'RTDT':
                    $row['status_badge'] =
                        '<span class="badge badge-primary">'
                        .$row['status_name'].
                        '</span>';
                break;
                case 'ONPR':
                    $row['status_badge'] =
                        '<span class="badge badge-warning">'
                        .$row['status_name'].
                        '</span>';

                break;
                case 'SCMPL':
                    $row['status_badge'] =
                        '<span class="badge badge-success">'
                        .$row['status_name'].
                        '</span>';
                break;

                case 'CANC':
                    $row['status_badge'] =
                        '<span class="badge badge-danger">'
                        .$row['status_name'].
                        '</span>';
                break;

                default:
                    $row['status_badge'] =
                        '<span class="badge badge-secondary">'
                        .$row['status_name'].
                        '</span>';
                break;
            }

            $row['action'] = '

                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail" data-id="'.$row['shipment_id'].'"
                    title="Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="javascript:void(0);"
                    class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1 btn-edit-shipment" data-id="'.$row['shipment_id'].'"
                    title="Edit">
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
    
}