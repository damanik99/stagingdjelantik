<?php

namespace App\Models;

use CodeIgniter\Model;

class GroupModel extends Model
{
    protected $table            = 'group';
    protected $primaryKey       = 'group_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'name',
        'level',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = false;
}