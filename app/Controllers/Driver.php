<?php

namespace App\Controllers;

use App\Models\ShipmentModel;

class Driver extends BaseController
{
    protected ShipmentModel $shipment;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->shipment = new ShipmentModel();
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

    public function destination($shipmentDetailId)
    {
        $destination = $this->shipment
            ->driverDestination($shipmentDetailId);

        if (!$destination) {
            return redirect()
                ->to(base_url('driver/index'))
                ->with('error', 'Destination tidak ditemukan.');
        }

        /*
        * Hitung total destination dalam shipment
        */
        $details = $this->shipment
            ->driverShipmentDetail($destination['shipment_id']);

        $totalDestination = count($details);

        return view('driver/destination', [
            'destination'     => $destination,
            'totalDestination' => $totalDestination,
        ]);
    }

    public function quantity()
    {
        return view('driver/quantity');
    }
}