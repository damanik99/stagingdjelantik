<?php

namespace App\Models;

use CodeIgniter\Model;

class KecamatanModel extends Model
{
    protected $table            = 'tbl_kecamatan';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'kabkot_id',
        'kecamatan'
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = false;

    public function getByKabkot(int $kabkotId): array
    {
        return $this->where('kabkot_id', $kabkotId)
            ->orderBy('kecamatan', 'ASC')
            ->findAll();
    }
}