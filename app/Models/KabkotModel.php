<?php

namespace App\Models;

use CodeIgniter\Model;

class KabkotModel extends Model
{
    protected $table            = 'tbl_kabkot';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'provinsi_id',
        'kabupaten_kota',
        'ibukota',
        'k_bsni'
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = false;

    public function getByProvince(int $provinceId): array
    {
        return $this->where('provinsi_id', $provinceId)
            ->orderBy('kabupaten_kota', 'ASC')
            ->findAll();
    }
}