<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyTypeModel extends Model
{
    protected $table = 'companytype';
    protected $primaryKey = 'type_id';

    protected $allowedFields = [
        'type_name',
        'description',
        'status',
        'created_by',
        'modified_by'
    ];

    protected $useTimestamps = false;

    public function getCompanyByType($typeCode, $programId)
    {
        return $this->db->table('company_program a')
            ->select("
                a.company_program_id, company_type_id,
                b.*
            ")
            ->join('company b', 'a.company_id = b.company_id')
            ->join('companytype c', 'a.company_type_id = c.type_id')
            ->where('c.type_code', $typeCode)
            ->where('a.program_id', $programId)
            ->orderBy('b.company_name', 'ASC')
            ->get()
            ->getResultArray();
    }
}