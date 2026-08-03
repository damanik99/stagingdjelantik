<?php

namespace App\Models;

use CodeIgniter\Model;

class StorageContainerModel extends Model
{
    protected $table            = 'storage_container';
    protected $primaryKey       = 'storage_container_id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'warehouse_id',
        'container_type_id',
        'container_code',
        'container_name',
        'capacity',
        'capacity_unit',
        'status_id',
        'note',
        'is_active',
        'is_deleted',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
        'deleted_date',
        'deleted_by'
    ];
}