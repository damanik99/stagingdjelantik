<?php

namespace App\Models;

use CodeIgniter\Model;

class StatusModel extends Model
{
    protected $table            = 'status';
    protected $primaryKey       = 'status_id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;

    protected $allowedFields = [
        'module',
        'status_code',
        'status_name',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];

    protected $useTimestamps = false;

    /**
     * Get status by module
     */
    public function getByModule($module)
    {
        return $this->where('module', strtoupper($module))
                    ->orderBy('status_name', 'ASC')
                    ->findAll();
    }

    /**
     * Get single status by module and code
     */
    public function getStatus($module, $statusCode)
    {
        return $this->where('module', strtoupper($module))
                    ->where('status_code', strtoupper($statusCode))
                    ->first();
    }

    
}