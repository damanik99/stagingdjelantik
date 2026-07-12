<?php

namespace App\Models;

use CodeIgniter\Model;

class KelurahanModel extends Model
{
    protected $table            = 'tbl_kelurahan';
    protected $primaryKey       = 'id';
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;

    protected $allowedFields = [
        'kecamatan_id',
        'kelurahan',
        'kd_pos'
    ];

    protected bool $allowEmptyInserts = false;

    protected $useTimestamps = false;

    public function getByKecamatan(int $kecamatanId): array
    {
        return $this->where('kecamatan_id', $kecamatanId)
            ->orderBy('kelurahan', 'ASC')
            ->findAll();
    }
}