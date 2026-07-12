<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationModel extends Model
{
    protected $table = 'organization';
    protected $primaryKey = 'organization_id';

    protected $allowedFields = [
        'organization_type_id',
        'organization_name',
        'pic_name',
        'state',
        'province',
        'city',
        'district',
        'village',
        'address',
        'phone',
        'email',
        'picture',
        'latitude',
        'longitude',
        'status_id',
        'note',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];

    protected $useTimestamps = false;
}