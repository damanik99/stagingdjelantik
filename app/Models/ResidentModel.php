<?php

namespace App\Models;

use CodeIgniter\Model;

class ResidentModel extends Model
{
    protected $table = 'resident';
    protected $primaryKey = 'resident_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'resident_code',
        'resident_name',
        'phone',
        'province',
        'city',
        'district',
        'village',
        'address',
        'latitude',
        'longitude',
        'active',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
    ];
}
