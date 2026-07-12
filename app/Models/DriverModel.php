<?php

namespace App\Models;

use CodeIgniter\Model;

class DriverModel extends Model
{
    protected $table = 'driver';
    protected $primaryKey = 'driver_id';

    protected $allowedFields = [
        'users_id',
        'company_program_id',
        'driver_type',
        'driver_name',
        'license_number',
        'license_type',
        'license_expiry_date',
        'active',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];
}