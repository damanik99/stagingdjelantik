<?php
namespace App\Models;

use CodeIgniter\Model;

class ContainerTypeModel extends Model
{
    protected $table            = 'container_type';
    protected $primaryKey       = 'container_type_id';
    protected $returnType       = 'array';

    protected $allowedFields    = [
        'container_type_code',
        'container_type_name',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];
}