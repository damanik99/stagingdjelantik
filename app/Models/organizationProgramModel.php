<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationProgramModel extends Model
{
    protected $table            = 'organization_program';
    protected $primaryKey       = 'organization_program_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'organization_id',
        'program_id',
        'organization_type_id',
        'status_id',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
    ];
}
