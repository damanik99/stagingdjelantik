<?php

namespace App\Models;

use CodeIgniter\Model;

class WarehouseModel extends Model
{
    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_id';

    protected $allowedFields = [
        'program_id',
        'warehouse_code',
        'warehouse_name',
        'address',
        'latitude',
        'longitude',
        'is_active',
        'is_deleted',
        'deleted_date',
        'deleted_by',
        'created_by',
        'modified_by'
    ];

    public function dataWarehouse()
    {
        $program_id = session()->get('program');

        $sql = 'SELECT * FROM warehouse a
                JOIN program b ON a.program_id = b.program_id
                WHERE is_active = "1" AND a.program_id ='.$program_id;

        return $this->db->query($sql)->getResultArray();
    }
}