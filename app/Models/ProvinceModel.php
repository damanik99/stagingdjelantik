<?php

namespace App\Models;

use CodeIgniter\Model;

class ProvinceModel extends Model
{
    protected $table            = 'tbl_provinsi';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'provinsi',
        'ibukota',
        'p_bsni'
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = false;
}