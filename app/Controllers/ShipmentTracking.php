<?php

namespace App\Controllers;

use App\Models\ShipmentTrackingModel;
use App\Models\ShipmentModel;
use App\Models\StatusModel;
use App\Models\QualityControlModel;

class ShipmentTracking extends BaseController
{
    protected ShipmentTrackingModel $shipmentTracking;
    protected StatusModel $status;
    protected ShipmentModel $shipment;
    protected QualityControlModel $qualityControl;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->shipmentTracking = new ShipmentTrackingModel();
        $this->shipment = new ShipmentModel();
        $this->status = new StatusModel();

        $this->qualityControl = new QualityControlModel();
    }

    public function index()
    {
        $data['title'] = 'Shipment';

        return view('ShipmentTracking/index', $data);
    }

    public function datatables()
    {
        $request = service('request');
        $program = session()->get('program');

        $draw   = $request->getPost('draw');
        $start  = (int) $request->getPost('start');
        $length = (int) $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $baseQuery = "
            FROM shipment s

            INNER JOIN company_program cpsp
                ON s.supplier_company_program_id = cpsp.company_program_id

            INNER JOIN company_program cpbp
                ON s.buyer_company_program_id = cpbp.company_program_id

            INNER JOIN company supplier
                ON cpsp.company_id = supplier.company_id

            INNER JOIN company buyer
                ON cpbp.company_id = buyer.company_id

            INNER JOIN driver d
                ON s.driver_id = d.driver_id

            INNER JOIN vehicle v
                ON s.vehicle_id = v.vehicle_id

            INNER JOIN program p
                ON cpsp.program_id = p.program_id

            LEFT JOIN (
                SELECT st1.*
                FROM shipment_tracking st1
                INNER JOIN (
                    SELECT shipment_id,
                        MAX(tracking_id) AS last_tracking_id
                    FROM shipment_tracking
                    GROUP BY shipment_id
                ) x
                ON st1.tracking_id = x.last_tracking_id
            ) last_tracking
                ON s.shipment_id = last_tracking.shipment_id

            LEFT JOIN status sts
                ON last_tracking.status_id = sts.status_id

            LEFT JOIN (
                SELECT
                    shipment.shipment_id,
                    qty_checkin,
                    qty_checkout
                FROM shipment_tracking
                JOIN shipment ON shipment_tracking.shipment_id = shipment.shipment_id
                GROUP BY shipment.shipment_id
            ) qty
                ON qty.shipment_id = s.shipment_id

            LEFT JOIN purchase_order po
                ON s.purchase_order_id = po.purchase_order_id

            WHERE p.program_id = ?
        ";

        $params = [$program];

        $filter = "";

        if (!empty($search)) {

            $filter .= "
                AND (
                    s.shipment_number LIKE ?
                    OR po.po_number LIKE ?
                    OR supplier.company_name LIKE ?
                    OR buyer.company_name LIKE ?
                    OR d.driver_name LIKE ?
                    OR v.plate_number LIKE ?
                    OR sts.status_name LIKE ?
                )
            ";

            for ($i = 0; $i < 7; $i++) {
                $params[] = "%{$search}%";
            }
        }

        $totalRecords = $this->db->query("SELECT COUNT(*) cnt {$baseQuery}", [$program])
            ->getRow()->cnt;

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

        $columns = [
            's.shipment_number',
            'po.po_number',
            'supplier.company_name',
            'buyer.company_name',
            'd.driver_name',
            'v.plate_number',
            'qty.qty_checkin',
            'unit_checkin',
            'qty.qty_checkout',
            'unit_checkout',
            's.departure_at',
            's.arrival_at',
            'sts.status_name'
        ];

        $orderColumn = $columns[$request->getPost('order')[0]['column'] ?? 0];
        $orderDir = $request->getPost('order')[0]['dir'] ?? 'DESC';

        $sql = "
            SELECT
                s.*,
                po.po_number,
                supplier.company_name AS supplier,
                buyer.company_name AS buyer,
                d.driver_name,
                v.plate_number,
                qty.qty_checkin,
                qty.qty_checkout,
                sts.status_name,
                sts.status_code,
                unit_checkout,
                unit_checkin

            {$baseQuery}

            {$filter}

            ORDER BY {$orderColumn} {$orderDir}

            LIMIT ?, ?
        ";

        $params[] = $start;
        $params[] = $length;

        $query = $this->db->query($sql, $params);

        $data = [];

        foreach ($query->getResultArray() as $row) {

            switch (strtoupper($row['status_code'])) {

                case 'PENDING':
                    $badge = '<span class="badge badge-warning">'.$row['status_name'].'</span>';
                    break;

                case 'CHECKIN':
                    $badge = '<span class="badge badge-info">'.$row['status_name'].'</span>';
                    break;

                case 'CHECKOUT':
                    $badge = '<span class="badge badge-primary">'.$row['status_name'].'</span>';
                    break;

                case 'DELIVERED':
                    $badge = '<span class="badge badge-success">'.$row['status_name'].'</span>';
                    break;

                default:
                    $badge = '<span class="badge badge-secondary">'.$row['status_name'].'</span>';
            }

            $row['status_badge'] = $badge;

            $row['action'] = '
                <a href="javascript:void(0)"
                    class="btn bg-gray-dark btn-sm text-white btnImage" data-id="'.$row['shipment_id'].'">
                    <i class="fa fa-image"></i>
                </a>
            ';

            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw' => intval($draw),
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data' => $data
        ]);
    }

    public function create($shipmentId = null)
    {
        
        if ($this->request->getMethod() === 'post') {

            try {

                $status = $this->status
                    ->where('module', 'SHIPMENT_TRACKING')
                    ->where('status_code', 'DLPN')
                    ->first();
                // var_dump($status);exit;
                if (!$status) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Status DLPN tidak ditemukan.'
                    ]);
                }
                // var_dump($shipmentId);die;
                $photo = $this->request->getFile('photo');

                if (!$photo->isValid()) {
                    throw new \Exception('Photo wajib diupload.');
                }

                if (!$this->request->getPost('latitude')) {
                    throw new \Exception('Lokasi GPS belum diperoleh.');
                }

                if (!$this->request->getPost('qty_checkin')) {
                    throw new \Exception('Volume Tidak Boleh Kosong ');
                }

                $fileName = $photo->getRandomName();

                if (!is_dir(ROOTPATH . 'public/upload/image/shipmenttracking')) {
                    mkdir(
                        ROOTPATH . 'public/upload/image/shipmenttracking',
                        0775,
                        true
                    );
                }

                $photo->move(
                    FCPATH . 'upload/image/shipmenttracking',
                    $fileName
                );

                $shipmentId = $this->request->getPost('shipment_id');

                $insertData = [
                    'shipment_id' => $shipmentId,
                    'photo'       => '/image/shipmenttracking/' . $fileName,
                    'latitude'    => $this->request->getPost('latitude'),
                    'longitude'   => $this->request->getPost('longitude'),
                    'location'    => $this->request->getPost('address'),
                    'notes'       => $this->request->getPost('notes'),
                    'status_id'   => $status['status_id'],
                    'created_by'  => session()->get('users_id')
                ];

                $this->shipmentTracking->insert($insertData);

                $statusShipment = $this->status
                    ->where('module', 'SHIPMENT')
                    ->where('status_code', 'SDLPN')
                    ->first();

                if (!$statusShipment) {
                    throw new \Exception('Status SDLPN tidak ditemukan.');
                }

                $this->shipment->update($shipmentId, [
                    'status_id'     => $statusShipment['status_id'],
                    'qty_checkin'   => $this->request->getPost('qty_checkin'),
                    'unit_checkin'  => $this->request->getPost('unit_checkin'),
                    'modified_by'   => session()->get('users_id'),
                    'modified_date' => date('Y-m-d H:i:s')
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Check-In berhasil disimpan.'
                ]);

            } catch (\Exception $e) {

                return $this->response->setJSON([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }

        $shipmentNumber = $this->shipment->getDetailShipment($shipmentId);

        $data = [
            'title'          => 'Check-In',
            'shipmentDetail' => $shipmentNumber
        ];

        return view('shipmenttracking/create', $data);
    }

    public function arrived($shipmentId)
    {
        
        $shipmentTrack = $this->shipment->getShipmentId($shipmentId);
        
        $data = [
            'title'          => 'Check-In',
            'shipmentTrack' => $shipmentTrack
        ];

        return view('shipmenttracking/arrived', $data);
    }

    public function arrivedsave($shipmentId = null)
    {
        if ($this->request->getMethod() === 'post') {
            // var_dump('test');exit;
            try {

                $status = $this->status
                    ->where('module', 'SHIPMENT_TRACKING')
                    ->where('status_code', 'SMBR')
                    ->first();
                
                if (!$status) {
                    return $this->response->setJSON([
                        'success' => false,
                        'message' => 'Status SMBR tidak ditemukan.'
                    ]);
                }
                // var_dump($shipmentId);die;
                $photo = $this->request->getFile('photo');

                if (!$photo->isValid()) {
                    throw new \Exception('Photo wajib diupload.');
                }

                if (!$this->request->getPost('latitude')) {
                    throw new \Exception('Lokasi GPS belum diperoleh.');
                }

                $extension = $photo->getExtension();

                $randomCode = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));

                $photoName = 'BYR' . date('Ymd') . $randomCode . '.' . $extension;

                $photo->move(
                    FCPATH . 'upload/image/shipmenttracking',
                    $photoName
                );

                $shipmentId = $this->request->getPost('shipment_id');

                $insertData = [
                    'shipment_id' => $shipmentId,
                    'photo'       => '/image/shipmenttracking/' . $photoName,
                    'latitude'    => $this->request->getPost('latitude'),
                    'longitude'   => $this->request->getPost('longitude'),
                    'location'    => $this->request->getPost('location'),
                    'notes'       => $this->request->getPost('notes'),
                    'status_id'   => $status['status_id'],
                    'created_by'  => session()->get('users_id')
                ];

                $this->shipmentTracking->insert($insertData);

                $statusShipment = $this->status
                    ->where('module', 'SHIPMENT')
                    ->where('status_code', 'DLVD')
                    ->first();

                if (!$statusShipment) {
                    throw new \Exception('Status DLVD tidak ditemukan.');
                }

                $this->shipment->update($shipmentId, [
                    'status_id'     => $statusShipment['status_id'],
                    'modified_by'   => session()->get('users_id'),
                    'modified_date' => date('Y-m-d H:i:s')
                ]);

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Sudah sampai di buyer berhasil disimpan.'
                ]);

            } catch (\Exception $e) {

                return $this->response->setJSON([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function checkout($shipmentId)
    {
        $shipmentTrack = $this->shipment->getShipmentId($shipmentId);

        $data = [
            'title' => 'Check-Out',
            'shipmentTrack' => $shipmentTrack
        ];

        return view('shipmenttracking/checkout', $data);
    }

    public function saveCheckout($shipmentId = null)
    {
        if ($this->request->getMethod() === 'post') {

            try {

                $statusTracking = $this->status
                    ->where('module', 'SHIPMENT_TRACKING')
                    ->where('status_code', 'CHCK')
                    ->first();

                if (!$statusTracking) {
                    throw new \Exception('Status CHECKOUT tidak ditemukan.');
                }

                if (!$this->request->getPost('ffa')) {
                    throw new \Exception('FFA Tidak boleh kosong');
                }

                if (!$this->request->getPost('mi')) {
                    throw new \Exception('M&I Tidak boleh kosong');
                }

                $statusShipment = $this->status
                    ->where('module', 'SHIPMENT')
                    ->where('status_code', 'SCMPL')
                    ->first();

                if (!$statusShipment) {
                    throw new \Exception('Status COMPLETED tidak ditemukan.');
                }

                $photo = $this->request->getFile('photo');

                if (!$photo->isValid()) {
                    throw new \Exception('Photo wajib diupload.');
                }

                if (!$this->request->getPost('latitude')) {
                    throw new \Exception('Lokasi GPS belum diperoleh.');
                }

                $fileName = $photo->getRandomName();

                $uploadPath = FCPATH . 'upload/image/shipmenttracking';

                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0775, true);
                }

                $photo->move($uploadPath, $fileName);

                $shipmentId = $this->request->getPost('shipment_id');

                /*
                |--------------------------------------------------------------------------
                | START TRANSACTION
                |--------------------------------------------------------------------------
                */
                $this->db->transBegin();

                /*
                |--------------------------------------------------------------------------
                | INSERT SHIPMENT TRACKING
                |--------------------------------------------------------------------------
                */
                $this->shipmentTracking->insert([
                    'shipment_id' => $shipmentId,
                    'photo'       => '/image/shipmenttracking/' . $fileName,
                    'latitude'    => $this->request->getPost('latitude'),
                    'longitude'   => $this->request->getPost('longitude'),
                    'location'    => $this->request->getPost('location'),
                    'notes'       => $this->request->getPost('notes'),
                    'status_id'   => $statusTracking['status_id'],
                    'created_by'  => session()->get('users_id')
                ]);

                /*
                |--------------------------------------------------------------------------
                | INSERT QUALITY CONTROL
                |--------------------------------------------------------------------------
                */
                $this->qualityControl->insert([
                    'shipment_id' => $shipmentId,
                    'company_name'=> $this->request->getPost('buyer'),
                    'qc_type'     => 'Buyer',
                    'result'      => $this->request->getPost('result'),
                    'ffa'         => $this->request->getPost('ffa'),
                    'mi'          => $this->request->getPost('mi'),
                    'photo'       => 'upload/image/qc/' . $fileName,
                    'notes'       => $this->request->getPost('notes'),
                    'status_id'   => $statusTracking['status_id'],
                    'created_by'  => session()->get('users_id')
                ]);

                /*
                |--------------------------------------------------------------------------
                | UPDATE SHIPMENT
                |--------------------------------------------------------------------------
                */
                $this->shipment->update($shipmentId, [
                    'qty_checkout' => $this->request->getPost('qtycheckout'),
                    'unit_checkout'=> $this->request->getPost('unit_checkout'),
                    'arrival_at'   => date('Y-m-d H:i:s'),
                    'status_id'    => $statusShipment['status_id'],
                    'modified_by'  => session()->get('users_id'),
                    'modified_date'=> date('Y-m-d H:i:s')
                ]);

                /*
                |--------------------------------------------------------------------------
                | COMMIT / ROLLBACK
                |--------------------------------------------------------------------------
                */
                if ($this->db->transStatus() === false) {

                    $this->db->transRollback();

                    throw new \Exception('Gagal menyimpan data checkout.');
                }

                $this->db->transCommit();

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Checkout berhasil disimpan.'
                ]);

            } catch (\Exception $e) {

                if ($this->db->transStatus()) {
                    $this->db->transRollback();
                }

                return $this->response->setJSON([
                    'success' => false,
                    'message' => $e->getMessage()
                ]);
            }
        }
    }

    public function detailimage($id)
    {
        $photo = $this->db->table('shipment_tracking')
                ->select('photo')
                ->where('shipment_id', $id)->get()->getResultArray();

        $data = [
            'photo' => $photo
        ];

        return view('dashboard/modalimage/viewimage', $data);
    }
}