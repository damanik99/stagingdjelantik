<?php

namespace App\Models;

use CodeIgniter\Model;

class OrganizationUserModel extends Model
{
    protected $table            = 'organization_user';
    protected $primaryKey       = 'organization_user_id';
    protected $useAutoIncrement = true;

    protected $allowedFields = [
        'organization_program_id',
        'users_id',
        'active',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by',
    ];

    public function detail($id)
    {
        $program_id = session()->get('program');

        $data = $this->db->table('organization_user ou')
            ->select('ou.*, organization_name, u.username, u.fullname, 
            u.phone, u.email, u.address, u.title, u.picture')
            ->join('organization_program op', 'ou.organization_program_id = op.organization_program_id')
            ->join('users u', 'ou.users_id = u.users_id')
            ->join('organization o', 'op.organization_id= o.organization_id')
            ->join('program p', 'op.program_id = p.program_id')
            ->where('ou.organization_user_id', $id)
            ->where('ou.active', '1')
            ->where('op.program_id', $program_id)
            ->get()->getRowArray();

        return $data;
    }
}
