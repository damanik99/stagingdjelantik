<?php

namespace App\Models;

use CodeIgniter\Model;

class VehicleModel extends Model
{
    protected $table            = 'vehicle';
    protected $primaryKey       = 'vehicle_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'company_program_id',
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
                ->select('a.*, c.company_name')
                ->join('company_program b', 'a.company_program_id = b.company_program_id')
                ->join('company c', 'b.company_id = c.company_id')
                ->where('a.vehicle_id', $id)
                ->get()->getRowArray();

        return $data;
    }
}