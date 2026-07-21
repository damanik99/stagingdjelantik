<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationModel extends Model
{
    protected $table = 'organization';
    protected $primaryKey = 'organization_id';

    protected $allowedFields = [
        'organization_type_id',
        'organization_name',
        'pic_name',
        'state',
        'province',
        'city',
        'district',
        'village',
        'address',
        'phone',
        'email',
        'picture',
        'latitude',
        'longitude',
        'status_id',
        'note',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];

    protected $useTimestamps = false;

    public function getOrganizationPro($id)
    {
        $data = $this->db->table('organization_program a')
                ->select('a.organization_program_id, b.*, d.status_code, d.status_name, 
                c.type_name, c.type_code, a.organization_type_id, a.status_id, c.type_name')
                ->join('organization b', 'a.organization_id = b.organization_id')
                ->join('organization_type c', 'a.organization_type_id = c.organization_type_id')
                ->join('status d', 'a.status_id = d.status_id')
                ->where('a.organization_program_id', $id)
                ->get()->getRowArray();

        return $data;
    }

    public function getTypeOrg($typename)
    {
        $program_id = session()->get('program');

        $data = $this->db->table('organization_program a')
                ->select('a.organization_program_id, b.organization_name, d.status_code, d.status_name')
                ->join('organization b', 'a.organization_id = b.organization_id')
                ->join('organization_type c', 'a.organization_type_id = c.organization_type_id')
                ->join('status d', 'a.status_id = d.status_id')
                ->where('a.program_id', $program_id)
                ->where('type_name', $typename)
                ->where('d.status_code', 'COMPANY')
                ->get()->getResultArray();

        return $data;
    }
}