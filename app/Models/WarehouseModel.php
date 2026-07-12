<?php

namespace App\Models;

use CodeIgniter\Model;

class WarehouseModel extends Model
{
    protected $table = 'warehouse';
    protected $primaryKey = 'warehouse_id';

    protected $allowedFields = [
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
}