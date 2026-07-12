<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationTypeModel extends Model
{
    protected $table = 'organization_type';
    protected $primaryKey = 'type_id';

    protected $allowedFields = [
        'type_name',
        'description',
        'status',
        'created_by',
        'modified_by'
    ];

    protected $useTimestamps = false;

}