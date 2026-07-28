<?php

namespace App\Models;

use CodeIgniter\Model;

class ShipmentDetailModel extends Model
{
    protected $table            = 'shipment_detail';
    protected $primaryKey       = 'shipment_detail_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'shipment_number',
        'shipment_id',
        'sequence_no',
        'activity_type',
        'organization_program_id',
        'departure_at',
        'arrival_at',
        'qty',
        'unit',
        'status_id',
        'note',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
    ];

    public function getShipmentDetail($shipmentId)
    {
        $sql = "
            SELECT
                s.*,
                d.driver_name,
                v.plate_number,

                sd.shipment_detail_id,
                sd.sequence_no,
                sd.activity_type,
                sd.departure_at,
                sd.arrival_at,
                sd.qty,
                sd.unit,
                sd.note,

                op.organization_program_id,
                o.organization_name

            FROM shipment_detail sd

            INNER JOIN shipment s
                ON sd.shipment_id = s.shipment_id

            INNER JOIN driver d
                ON s.driver_id = d.driver_id

            INNER JOIN vehicle v
                ON s.vehicle_id = v.vehicle_id

            INNER JOIN organization_program op
                ON sd.organization_program_id = op.organization_program_id

            INNER JOIN organization o
                ON op.organization_id = o.organization_id

            WHERE s.shipment_id = ?

            ORDER BY sd.sequence_no ASC
        ";

        return $this->db
            ->query($sql, [$shipmentId])
            ->getResultArray();
    }

}