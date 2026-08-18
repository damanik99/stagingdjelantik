<?php

namespace App\Controllers;

use App\Models\ShipmentTrackingModel;
use App\Models\ShipmentModel;
use App\Models\StatusModel;
use App\Models\ShipmentDetailModel;

class Driver extends BaseController
{
    protected ShipmentModel $shipment;
    protected ShipmentTrackingModel $shipmentTracking;
    protected StatusModel $status;
    protected ShipmentDetailModel $shipmentDetail;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: ' . base_url('auth'));
            exit();
        }

        $this->shipmentTracking = new ShipmentTrackingModel();
        $this->shipment = new ShipmentModel();
        $this->status = new StatusModel();
        $this->shipmentDetail = new ShipmentDetailModel();
    }

    // public function index()
    // {
    //     $users_id = session()->get('users_id');
    //     $driver = $this->db->table('driver')->select('driver_id')->where('users_id', $users_id)->get()->getRowArray();
    //     $shipments = $this->shipment->driverSipment($driver['driver_id']);

    //     foreach ($shipments as $shipment) 
    //     {
    //         $shipment['details'] = $this->shipment->driverShipmentDetail($shipment['shipment_id']);

    //     }

    //     unset($shipment);

    //     return view('driver/index', [
    //         'shipments' => $shipments
    //     ]);
    // }

    public function index()
    {
        $driverId = session()->get('driver_id');

        $shipments = $this->shipment->driverSipment($driverId);

        foreach ($shipments as &$shipment) {

            $details = $this->shipment->driverShipmentDetail($shipment['shipment_id']);

            $shipment['details'] = $details;

            $shipment['total_destination'] = count($details);

            $completedDestination = 0;

            foreach ($details as $detail) {
                if (($detail['status_code'] ?? '') === 'SCMPL') {
                    $completedDestination++;
                }
            }

            $shipment['completed_destination'] = $completedDestination;

            $shipment['progress'] = count($details) > 0
                ? ($completedDestination / count($details)) * 100
                : 0;
        }

        unset($shipment);

        return view('driver/index', [
            'shipments' => $shipments
        ]);
    }

    public function detail($shipmentId)
    {
        $shipment = $this->shipment->driverShipmentById($shipmentId);

        if (!$shipment) {
            return redirect()
                ->to(base_url('driver/index'))
                ->with('error', 'Shipment tidak ditemukan.');
        }

        $details = $this->shipment->driverShipmentDetail($shipmentId);
        $totalDestination = count($details);
        $completedDestination = 0;

        foreach ($details as $detail) {
            if (($detail['status_code'] ?? '') === 'SCMPL') {
                $completedDestination++;
            }
        }

        $progress = $totalDestination > 0
            ? ($completedDestination / $totalDestination) * 100
            : 0;

        return view('driver/detail', [
            'shipment'              => $shipment,
            'details'               => $details,
            'totalDestination'      => $totalDestination,
            'completedDestination'  => $completedDestination,
            'progress'              => $progress,
        ]);
    }

    // START DESTINATION
    public function destination($shipmentDetailId)
    {
        $destination = $this->shipment->driverDestination($shipmentDetailId);

        if (!$destination) {
            return redirect()
                ->to(base_url('driver/index'))
                ->with('error', 'Destination tidak ditemukan.');
        }

        /*
        * Hitung total destination dalam shipment
        */
        $details = $this->shipment->driverShipmentDetail($destination['shipment_id']);

        $totalDestination = count($details);

        return view('driver/destination', [
            'destination'     => $destination,
            'totalDestination' => $totalDestination,
        ]);
    }

    public function startDelivery($shipmentDetailId)
    {
        $destination = $this->shipment
            ->driverDestination($shipmentDetailId);

        if (!$destination) {
            return redirect()
                ->back()
                ->with('error', 'Destination tidak ditemukan.');
        }

        $driverId = session()->get('driver_id');

        // Pastikan shipment milik driver yang login
        if ((int) $destination['driver_id'] !== (int) $driverId) {
            return redirect()
                ->back()
                ->with('error', 'Shipment bukan milik driver ini.');
        }

        $updated = $this->shipment
            ->updateShipmentDetailStatusByCode(
                $shipmentDetailId,
                'SDLPN'
            );

        if (!$updated) {
            return redirect()
                ->back()
                ->with('error', 'Gagal memulai delivery.');
        }

        return redirect()
            ->to(
                base_url(
                    'driver/destination/' . $shipmentDetailId
                )
            )
            ->with('success', 'Delivery dimulai.');
    }

    public function cancelDelivery($shipmentDetailId)
    {
        $destination = $this->shipment
            ->driverDestination($shipmentDetailId);

        if (!$destination) {
            return redirect()
                ->back()
                ->with('error', 'Destination tidak ditemukan.');
        }

        $driverId = session()->get('driver_id');

        if ((int) $destination['driver_id'] !== (int) $driverId) {
            return redirect()
                ->back()
                ->with('error', 'Shipment bukan milik driver ini.');
        }

        $updated = $this->shipment
            ->updateShipmentDetailStatusByCode(
                $shipmentDetailId,
                'RTDT'
            );

        if (!$updated) {
            return redirect()
                ->back()
                ->with('error', 'Gagal membatalkan delivery.');
        }

        return redirect()
            ->to(
                base_url(
                    'driver/destination/' . $shipmentDetailId
                )
            )
            ->with('success', 'Delivery dibatalkan.');
    }
    // END DESTINATION

    public function quantity()
    {
        return view('driver/quantity');
    }

    public function arrival($shipmentDetailId)
    {
        $details = $this->shipment->driverDestination($shipmentDetailId);
        // var_dump($details);
        // exit;
        return view('driver/arrival', [
            'shipmentDetailId' => $shipmentDetailId
        ]);
    }

    public function arrivalCreate($shipmentDetialId)
    {
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


            $photo = $this->request->getFile('photo');

            if (!$photo->isValid()) {
                throw new \Exception('Photo wajib diupload.');
            }

            if (!$this->request->getPost('latitude')) {
                throw new \Exception('Lokasi GPS belum diperoleh.');
            }

            if (!$this->request->getPost('volume')) {
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
                'shipmen_detail_id' => $shipmentDetialId,
                'photo'       => '/image/shipmenttracking/' . $fileName,
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
                ->where('status_code', 'SCMPL')
                ->first();

            if (!$statusShipment) {
                throw new \Exception('Status SDLPN tidak ditemukan.');
            }
            // var_dump($this->request->getPost());
            // exit;
            $this->shipmentDetail->update($shipmentDetialId, [
                'status_id'     => $statusShipment['status_id'],
                'qty'   => $this->request->getPost('volume'),
                'unit'  => $this->request->getPost('unit'),
                'modified_by'   => session()->get('users_id'),
                'modified_date' => date('Y-m-d H:i:s')
            ]);

            return $this->response->setJSON([
                'success' => true,
                'message' => 'COMPLETED'
            ]);
        } catch (\Exception $e) {

            return $this->response->setJSON([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
