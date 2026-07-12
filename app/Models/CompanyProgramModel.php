<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyProgramModel extends Model
{
    protected $table      = 'company_program';
    protected $primaryKey = 'company_program_id';

    protected $allowedFields = [
        'company_id',
        'program_id',
        'company_type_id',
        'status_id',
        'created_by',
        'modified_by'
    ];
}