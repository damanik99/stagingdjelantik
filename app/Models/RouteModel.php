<?php

namespace App\Models;

use CodeIgniter\Model;

class RouteModel extends Model
{
    protected $table = 'route';
    protected $primaryKey = 'route_id';

    protected $returnType = 'array';

    protected $allowedFields = [
        'page_id',
        'action_id',
        'uri',
        'http_method',
        'controller',
        'method',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
    ];
}
