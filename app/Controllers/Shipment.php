<?php

/** Controller Shipment untuk proses Shipment Collection  */

namespace App\Controllers;

use App\Models\ShipmentModel;
use App\Models\CompanyModel;
use App\Models\CompanyTypeModel;
use App\Models\DriverModel;
use App\Models\VehicleModel;
use App\Models\PurchaseOrderModel;
use App\Models\StatusModel;
use App\Models\OrganizationModel;
use App\Models\ShipmentDetailModel;
use App\Models\WarehouseModel;

class Shipment extends BaseController
{
    protected ShipmentModel $shipment;
    protected CompanyModel $company;
    protected CompanyTypeModel $companyType;
    protected OrganizationModel $organizationModel;
    protected ShipmentDetailModel $shipmentDetail;
    protected WarehouseModel $warehouse;

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
        $this->company = new CompanyModel();
        $this->companyType = new CompanyTYpeModel();
        $this->organizationModel = new OrganizationModel();
        $this->shipmentDetail = new ShipmentDetailModel();
        $this->warehouse = new WarehouseModel();
    }

    public function index()
    {
        $data['title'] = 'Shipment';

        return view('shipment/index', $data);
    }

    public function Create()
    {
        $organization = $this->organizationModel->getDataOrg();
        $buyer   = $this->organizationModel->getTypeOrg('BUYER');
        $warehouse = $this->warehouse->dataWarehouse();
        
        $vehicle  = (new VehicleModel())->findAll();
        
        $status = (new StatusModel())->where('module', 'SHIPMENT')->findAll();

        $dataDriver = $this->db->table('driver')->get()->getResultArray();

        $data = [
            'driver' => $dataDriver,
            'status' => $status,
            'organization' => $organization,
            'buyer' => $buyer,
            'vehicle' =>  $vehicle,
            'warehouse' => $warehouse
        ];

        return view('shipment/create', $data);
    }

    /** Start Create Shipment Collection 
     * ================================================
    */
    
    /**
     * Validate Collection Route
     *
     * @param array $routes
     * @return string|null
     */
    private function validateRoute(array $routes): ?string
    {
        if (count($routes) < 2) {
            return 'Collection must have at least 2 routes.';
        }

        $pickupCount = 0;
        $dropCount   = 0;

        $lastIndex = array_key_last($routes);

        foreach ($routes as $index => $route) {

            $activity     = strtoupper(trim($route['activity_type'] ?? ''));
            $organization = $route['organization_program_id'] ?? null;
            $warehouse    = $route['warehouse_id'] ?? null;

            // ==========================
            // Organization / Warehouse
            // ==========================

            // Keduanya kosong
            if (empty($organization) && empty($warehouse)) {
                return 'Row '.($index + 1).': Organization or Warehouse is required.';
            }

            // Keduanya terisi
            if (!empty($organization) && !empty($warehouse)) {
                return 'Row '.($index + 1).': Organization and Warehouse cannot both be selected.';
            }

            // ==========================
            // Activity
            // ==========================

            if (empty($activity)) {
                return 'Row '.($index + 1).': Activity type is required.';
            }

            switch ($activity) {

                case 'PICKUP':
                    $pickupCount++;
                    break;

                case 'DROPOFF':
                    $dropCount++;

                    if ($index !== $lastIndex) {
                        return 'DROPOFF must be the last route.';
                    }
                    break;

                default:
                    return "Invalid activity type '{$activity}'.";
            }
        }

        if ($pickupCount < 1) {
            return 'Collection must have at least one PICKUP.';
        }

        if ($dropCount !== 1) {
            return 'Collection must have exactly one DROPOFF.';
        }

        return null;
    }

    private function validateDuplicateOrganization(array $routes): ?string
    {
        $organizations = [];

        foreach ($routes as $route) {

            $organizationId = $route['organization_program_id'] ?? null;

            if (empty($organizationId)) {
                continue;
            }

            if (isset($organizations[$organizationId])) {
                return 'Organization cannot be selected more than once.';
            }

            $organizations[$organizationId] = true;
        }

        return null;
    }

    public function save()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'driver_id' => [
                'label' => 'Driver',
                'rules' => 'required|integer'
            ],
            'vehicle_id' => [
                'label' => 'Vehicle',
                'rules' => 'required|integer'
            ],
            'shipment_type' => [
                'label' => 'Shipment Type',
                'rules' => 'required'
            ],
            'route' => [
                'label' => 'Route',
                'rules' => 'required'
            ]
        ];

        // Validasi setiap route
        $routes = $this->request->getPost('route');

        $error = $this->validateRoute($routes);

        if ($error !== null) {
            
            return $this->response->setJSON([
                'success' => false,
                'message' => $error
            ]);
        }

        if (empty($routes) || count($routes) < 2) {
            return $this->response->setJSON([
                'success' => false,
                'errors' => [
                    'route' => 'Collection must have at least 2 route.'
                ]
            ]);
        }

        $error = $this->validateDuplicateOrganization($routes);

        if ($error !== null) {
            return $this->response->setJSON([
                'success' => false,
                'message' => $error
            ]);
        }

        if (!empty($routes)) {
            foreach ($routes as $i => $route) {

                $rules["route.$i.activity_type"] = [
                    'label' => "Activity Row ".($i),
                    'rules' => 'required'
                ];

                $rules["route.$i.departure_at"] = [
                    'label' => "Departure Row ".($i),
                    'rules' => 'required'
                ];

                $rules["route.$i.arrival_at"] = [
                    'label' => "Arrival Row ".($i),
                    'rules' => 'required'
                ];

                $rules["route.$i.sequence_no"] = [
                    'label' => "Sequence Row ".($i),
                    'rules' => 'required|integer'
                ];
            }
        }

        if (!$this->validate($rules)) {

            $errors = $this->validator->getErrors();
            return $this->response->setJSON([
                'success' => false,
                'message' => implode("\n", $errors),
                'errors'  => $errors
            ]);
        }

        $db = \Config\Database::connect();

        $db->transBegin();

        try {

            $shipmentNumber = $this->shipment->generateShipmentNumber();

            $shipment = [

                'shipment_number'   => $shipmentNumber,
                'purchase_order_id' => $this->request->getPost('purchase_order_id') ?: null,
                'shipment_type'     => $this->request->getPost('shipment_type'),
                'driver_id'         => $this->request->getPost('driver_id'),
                'vehicle_id'        => $this->request->getPost('vehicle_id'),
                'completed_at'      => null,
                'status_id'         => 11,
                'created_date'      => date('Y-m-d H:i:s'),
                'modified_date'     => date('Y-m-d H:i:s'),
                'created_by'        => session()->get('users_id'),
                'modified_by'       => session()->get('users_id')
            ];

            $this->shipment->insert($shipment);
            

            $shipmentId = $this->shipment->getInsertID();

            foreach ($routes as $route) {

                $detail = [

                    'shipment_id'                => $shipmentId,
                    'sequence_no'                => $route['sequence_no'],
                    'activity_type'              => $route['activity_type'],
                    'organization_program_id'    => !empty($route['organization_program_id']) ? (int)$route['organization_program_id']: null,
                    'warehouse_id'               => !empty($route['warehouse_id']) ? (int)$route['warehouse_id']: null,
                    'departure_at'               => $route['departure_at'],
                    'arrival_at'                 => $route['arrival_at'],
                    'unit'                       => null,
                    'status_id'                  => 11,
                    'note'                       => null,
                    'created_date'               => date('Y-m-d H:i:s'),
                    'modified_date'              => date('Y-m-d H:i:s'),
                    'created_by'                 => session()->get('users_id'),
                    'modified_by'                => session()->get('users_id')

                ];

                $this->shipmentDetail->insert($detail);

            }

            if ($db->transStatus() === false) {

                $db->transRollback();

                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to save shipment.'
                ]);
            }

            $db->transCommit();

            return $this->response->setJSON([
                'success' => true,
                'message' => 'Shipment successfully created'
            ]);

        } catch (\Throwable $e) {

            $db->transRollback();

            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function detail($shipmentId)
    {
        $routes = $this->shipmentDetail->getShipmentDetail($shipmentId);

        if (empty($routes)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('shipment/detail', [
            'title' => 'Detail Shipment',
            'shipment' => $routes[0],
            'routes'   => $routes
        ]);
    }

    public function edit($shipmentId)
    {
        $shipmentModel = new ShipmentModel();
        $detailModel   = new ShipmentDetailModel();

        $organization = $this->organizationModel->getDataOrg();

        // $shipment = $shipmentModel->find($shipmentId);
        $shipment = $this->shipment->dataShipment($shipmentId);

        $vehicle  = (new VehicleModel())->findAll();
        // $data['po'] = (new PurchaseOrderModel())->findAll();
        
        $status = (new StatusModel())->where('module', 'SHIPMENT')->findAll();

        $dataDriver = $this->db->table('driver')->get()->getResultArray();

        $warehouse = $this->warehouse->dataWarehouse();

        if (!$shipment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $routes = $this->db->table('shipment_detail a')
            ->select('a.shipment_detail_id, a.warehouse_id, a.organization_program_id, sequence_no, activity_type, o.organization_name, a.departure_at, a.arrival_at')
            ->join('organization_program op', 'a.organization_program_id = op.organization_program_id', 'left')
            ->join('organization o', 'op.organization_id = o.organization_id', 'left')
            ->join('warehouse w', 'a.warehouse_id = w.warehouse_code', 'left')
            ->where('shipment_id', $shipmentId)
            ->orderBy('sequence_no')
            ->get()->getResultArray();

        return view('shipment/edit', [
            'shipment'  => $shipment,
            'routes'    => $routes,
            'driver'    => $dataDriver,
            'vehicle'   => $vehicle,
            'organization' => $organization,
            'warehouse' => $warehouse
        ]);
    }

    private function validateCollectionRoute(array $routes): ?string
    {
        if (count($routes) < 2) {
            return 'Collection must have at least 2 routes.';
        }

        $pickupCount = 0;
        $dropCount   = 0;

        $lastIndex = array_key_last($routes);

        foreach ($routes as $index => $route) {

            $activity = strtoupper(trim($route['activity_type'] ?? ''));

            if (empty($activity)) {
                return 'Activity type is required.';
            }

            switch ($activity) {

                case 'PICKUP':
                    $pickupCount++;
                    break;

                case 'DROPOFF':
                    $dropCount++;

                    if ($index !== $lastIndex) {
                        return 'DROPOFF must be the last route.';
                    }
                    break;

                default:
                    return "Invalid activity type '{$activity}'.";
            }
        }

        if ($pickupCount < 1) {
            return 'Collection must have at least one PICKUP.';
        }

        if ($dropCount !== 1) {
            return 'Collection must have exactly one DROPOFF.';
        }

        return null;
    }

    private function validateUpdate($shipment, $post)
    {
        if ($shipment['status_id'] == '10') {

            if ($shipment['driver_id'] != $post['driver_id']) {
                throw new \Exception(
                    'Driver tidak dapat diubah.'
                );
            }

            if ($shipment['vehicle_id'] != $post['vehicle_id']) {
                throw new \Exception(
                    'Vehicle tidak dapat diubah.'
                );
            }
        }

        // =========================================
        // Validate Route
        // =========================================
        $routes = $post['route'] ?? [];

        if (empty($routes)) {
            throw new \Exception(
                'Shipment route tidak boleh kosong.'
            );
        }

        foreach ($routes as $index => $route) {

            $routeNumber = $index + 1;

            // Departure wajib
            if (empty($route['departure_at'])) {
                throw new \Exception(
                    "Departure pada route {$routeNumber} wajib diisi."
                );
            }

            // Arrival wajib
            if (empty($route['arrival_at'])) {
                throw new \Exception(
                    "Arrival pada route {$routeNumber} wajib diisi."
                );
            }
        }

        // Business validation collection
        $error = $this->validateCollectionRoute($routes);

        if ($error !== null) {
            throw new \Exception($error);
        }
    }

    public function updateCollection($shipmentId)
    {
        $shipment = $this->shipment->dataShipment($shipmentId);

        if (!$shipment) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Shipment tidak ditemukan.'
            ]);
        }

        $allowedStatus = [
            'RTDT',
        ];

        if (!in_array($shipment['status_code'], $allowedStatus, true)) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Cannot be changed .'
            ]);
        }

        $post = $this->request->getPost();

        $routes = $this->request->getPost('route');

        $this->validateUpdate($shipment, $post);

        $this->validateCollectionRoute($routes);

        $this->db->transBegin();

        try {
                
                $this->replaceShipmentDetail($shipmentId, $routes);

                $this->updateShipmentHeader($shipment);

                if ($this->db->transStatus() === false) {
                    throw new \Exception('Database transaction failed.');
                }

                $this->db->transCommit();

                return $this->response->setJSON([
                    'status' => true,
                    'message' => 'Shipment updated successfully.'
                ]);

            } catch (\Throwable $e) {

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => $e->getMessage()
                ]);
            }
    }

    private function updateShipmentHeader(array $shipment)
    {
        $data = [];
        
        if ($shipment['status_id'] == '11') {

            $data['driver_id'] = $this->request->getPost('driver_id');
            $data['vehicle_id'] = $this->request->getPost('vehicle_id');

        }

        if (!empty($data)) {
            $this->shipment->update(
                $shipment['shipment_id'],
                $data
            );
        }
    }

    private function replaceShipmentDetail($shipmentId, array $routes)
    {
        $this->shipmentDetail
            ->where('shipment_id', $shipmentId)
            ->delete();

        foreach ($routes as $route) {

            $route['organization_program_id'] = empty($route['organization_program_id']) ? null : $route['organization_program_id'];
            $route['warehouse_id'] = empty($route['warehouse_id']) ? null : $route['warehouse_id'];

            unset($route['shipment_detail_id']);

            // Normalisasi nilai kosong menjadi NULL
            $route['shipment_id'] = $shipmentId;
            $route['status_id']   = 11;
            
            if (!$this->shipmentDetail->insert($route)) {
                throw new \Exception(
                    implode(', ', $this->shipmentDetail->errors())
                );
            }
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
            LEFT JOIN organization_program op
                ON e.organization_program_id = op.organization_program_id
            LEFT JOIN warehouse w
                ON e.warehouse_id = w.warehouse_id
            LEFT JOIN program p
                ON p.program_id = COALESCE(op.program_id, w.program_id)
            LEFT JOIN organization o
                ON op.organization_id = o.organization_id
            WHERE COALESCE(op.program_id, w.program_id) = ?
        ";

        $filter = "";
        $params = [$program_id];

        if (!empty($search)) {

            $filter .= "
                AND (
                    a.shipment_number LIKE ?
                    OR a.shipment_type LIKE ?
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
            'a.shipment_type',
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
    
    public function driver()
    {
        $shipmentModel = new \App\Models\ShipmentModel();
        $driverId = session()->get('driver_id');
        $data['shipment'] = $shipmentModel->getActiveShipmentDriver($driverId);
        
        return view('driver/home', $data);
    }

    // Driver
    public function details($shipmentId)
    {
        $shipmentModel = new \App\Models\ShipmentModel();

        $driverId = session()->get('driver_id');
        $shipment = $shipmentModel->getDetailShipmentDriver($shipmentId, $driverId);

        if (!$shipment) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        $data['shipment'] = $shipment;
        return view('shipment/driver/detail', $data);
    }

    // Dropdown driver
    public function get_driver($company_program_id)
    {
        $driver = $this->db->table('driver d')
            ->select('d.driver_id, d.driver_name')
            ->join('company_program cp', 'cp.company_program_id = d.company_program_id')
            ->where('cp.company_program_id', $company_program_id)
            ->get()->getResultArray();

        return $this->response->setJSON($driver);
    }

    // Dropdown vehicle
    public function get_vehicle($company_program_id)
    {
        $vehicle = $this->db->table('vehicle v')
            ->select('v.vehicle_id, v.plate_number, v.brand')
            ->join('company_program cp', 'cp.company_program_id = v.company_program_id')
            ->where('cp.company_program_id', $company_program_id)
            ->get()->getResultArray();
        
            return $this->response->setJSON($vehicle);
    }

    public function checkEditAccess($id)
    {
        $dataShipment = $this->shipment->getDetailShipment($id);

        if ($dataShipment['status_code'] == 'RTDT') {
            return $this->response->setJSON([
                'success' => true
            ]);
        }

        return $this->response->setJSON([
            'success' => false,
            'message' => 'Operation "Berhasil". Unable to access the shipment edit page.'
        ]);
    }

    public function edits($id)
    {
        $dataShipment = $this->shipment->getDetailShipment($id);
        $warehouse = $this->warehouse->dataWarehouse();

        if ($dataShipment['status_code'] == 'RTDT') {

            $program_id = session()->get('program');

            $supplier = $this->companyType->getCompanyByType('SUPPLIER', $program_id);
            $buyer    = $this->companyType->getCompanyByType('BUYER', $program_id);
            $driver   = (new DriverModel())->findAll();
            $vehicle  = (new VehicleModel())->findAll();
            $status = (new StatusModel())->where('module', 'SHIPMENT')->findAll();

             $data = [
                'title' => 'Edit Shipment',
                'edit' => $dataShipment,
                'buyer' => $buyer,
                'driver' => $driver,
                'vehicle' => $vehicle,
                'supplier' => $supplier,
                'status' => $status
            ];

            return view('shipment/edit', $data);

        }
    }
    
    public function saveedit($id)
    {
        $dataShipment = $this->shipmentDetail->getDetailShipment($id);
        if ($dataShipment['status_code'] == 'RTDT') {

            if (!$this->request->isAJAX()) {
                return redirect()->back();
            }

            $shipment = $this->shipment->find($id);

            if (!$shipment) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Shipment not found.'
                ]);
            }

            $fields = [
                'shipment_number',
                'purchase_order_id',
                'supplier_company_program_id',
                'buyer_company_program_id',
                'driver_id',
                'vehicle_id',
                'departure_at',
                'arrival_at',
            ];

            $updateData = [];
            
            foreach ($fields as $field) {

                $newValue = trim((string) $this->request->getPost($field));
                $oldValue = trim((string) ($shipment[$field] ?? ''));

                if ($oldValue !== $newValue) {
                    $updateData[$field] = $newValue;
                }
            }

            // Selalu update modified_by jika ada perubahan
            if (!empty($updateData)) {

                $updateData['modified_by'] = session()->get('user_id');

                if (!$this->shipment->update($id, $updateData)) {

                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Failed to update shipment.'
                    ]);
                }

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Shipment updated successfully.'
                ]);
            }

            return $this->response->setJSON([
                'success' => true,
                'message' => 'No changes detected.'
            ]);
        }
        else
        {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Shipment Status "Berhasil". Unable to access the shipment edit page.'
            ]);
        }  
    }
    
}