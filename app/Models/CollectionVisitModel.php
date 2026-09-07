<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionVisitModel extends Model
{
    protected $table = 'collection_visit';
    protected $primaryKey = 'collection_visit_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'visit_number',
        'users_id',
        'organization_program_id',
        'resident_id',
        'visit_date',
        'visit_time',
        'qty',
        'unit',
        'status_id',
        'note',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
    ];
}
