<?php

namespace App\Models;

use CodeIgniter\Model;

class ShipmentTrackingModel extends Model
{
    protected $table            = 'shipment_tracking';
    protected $primaryKey       = 'tracking_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'shipment_id',
        'photo',
        'latitude',
        'longitude',
        'notes',
        'location',
        'status_id',
        'created_date',
        'created_by'
    ];

    protected $useTimestamps = false;

    public function getByShipment($shipmentId)
    {
        return $this->db->table('shipment_tracking a')
            ->select("
                a.*,
                b.name AS status_name,
                c.fullname AS created_name
            ")
            ->join('status b', 'a.status_id = b.status_id', 'left')
            ->join('users c', 'a.created_by = c.users_id', 'left')
            ->where('a.shipment_id', $shipmentId)
            ->orderBy('a.created_date', 'ASC')
            ->get()
            ->getResultArray();
    }

    public function getLastTracking($shipmentId)
    {
        return $this->db->table('shipment_tracking')
            ->where('shipment_id', $shipmentId)
            ->orderBy('tracking_id', 'DESC')
            ->limit(1)
            ->get()
            ->getRowArray();
    }

    public function getAllShipmentTracking()
    {
        $program = session()->get('program');
        
        $query = $this->db->query('SELECT b.*, cps.`company_name` AS supplier, cpb.`company_name` AS buyer, 
                dr.`driver_name`, v.`plate_number`, s.`status_name`, s.`status_code`
                FROM shipment_tracking a
                LEFT JOIN shipment b ON a.`shipment_id` = b.`shipment_id`
                JOIN company_program c ON b.`supplier_company_program_id` = c.`company_program_id`
                LEFT JOIN purchase_order po ON b.`purchase_order_id` = po.`purchase_order_id`
                JOIN company_program d ON b.`buyer_company_program_id` = d.`company_program_id`
                JOIN driver dr ON b.`driver_id` = dr.`driver_id`
                JOIN vehicle v ON b.`vehicle_id` = v.`vehicle_id`
                LEFT JOIN `status` s ON b.`status_id` = s.`status_id`
                LEFT JOIN company cps ON c.`company_id` = cps.`company_id`
                LEFT JOIN company cpb ON d.`company_id` = cpb.`company_id`
                LEFT JOIN program p ON c.`program_id` = p.`program_id`
                WHERE p.`program_id` = '.$program);

        return $query->getResultArray();
    }
}