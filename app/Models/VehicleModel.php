<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table            = 'vehicle';
    protected $primaryKey       = 'vehicle_id';
    protected $returnType       = 'array';

    protected $allowedFields = [
        'organization_program_id',
        'warehouse_id',
        'plate_number',
        'vehicle_type',
        'capacity_weight',
        'capacity_volume',
        'brand',
        'stnk_expiry_date',
        'kir_expiry_date',
        'status',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];

    protected $useTimestamps = false;

    public function getDataVehicle($id)
    {
        $data = $this->db->table('vehicle a')
                ->select('a.*, c.organization_name')
                ->join('organization_program b', 'a.organization_program_id = b.organization_program_id')
                ->join('organization c', 'b.organization_id = c.organization_id')
                ->where('a.vehicle_id', $id)
                ->get()->getRowArray();

        return $data;
    }
}