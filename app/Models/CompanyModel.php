<?php

namespace App\Models;

use CodeIgniter\Model;

class CompanyModel extends Model
{
    protected $table = 'company';
    protected $primaryKey = 'company_id';

    protected $allowedFields = [
        'company_type_id',
        'company_name',
        'pic_name',
        'phone',
        'email',
        'address',
        'latitude',
        'longitude',
        'status_id',
        'created_by',
        'modified_by'
    ];

    protected $useTimestamps = false;

    public function getCompany($companyId)
    {
        return $this->where('company_id', $companyId)
                    ->first();
    }

    public function detail($id)
    {
        $program_id = session()->get('program');
        $detail = $this->db->table('company_program a')
                       ->select('b.*, a.program_id, ct.type_name, s.status_name')
                       ->join('company b', 'a.company_id = b.company_id')
                       ->join('companytype ct', 'a.company_type_id = ct.type_id')
                       ->join('program c', 'a.program_id = c.program_id')
                       ->join('status s', 'a.status_id = s.status_id')
                       ->where('a.company_program_id', $id)
                       ->where('c.program_id', $program_id)
                       ->get()->getRowArray();

        return $detail;
    }

    public function datacompany()
    {
        $dataCompany = $this->db->table('company_program a')
            ->select('b.company_id, a.company_program_id, d.type_id, b.company_name')
            ->join('company b', 'a.company_id = b.company_id')
            ->join('program c', 'a.program_id = c.program_id')
            ->join('companytype d', 'a.company_type_id = d.type_id')
            ->get()->getResultArray();
        return $dataCompany;
    }

    
}