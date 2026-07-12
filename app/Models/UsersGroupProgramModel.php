<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersGroupProgramModel extends Model
{
    protected $table      = 'usersgroupprogram';
    protected $primaryKey = 'users_group_program_id';

    protected $allowedFields = ['users_id', 'group_id', 'program_id', 'data_level', 'created_date', 'modified_date', 'created_by', 'modified_by', 'picture'];


    public function index($id = false)
    {
        $users_id = session()->get('users_id');
        $program_id = session()->get('program');

        $builder = $this->db->table($this->table);
        $builder->select('users_group_program_id, users.users_id, users.username, group.group_id, 
        group.name as group_name, program.program_id, usersgroupprogram.data_level, group.name AS group_name,
        program.name as program_name, usersgroupprogram.created_date, 
        usersgroupprogram.modified_date');
        $builder->join('users', 'usersgroupprogram.users_id = users.users_id');
        $builder->join('group', 'usersgroupprogram.group_id = group.group_id');
        $builder->join('program', 'usersgroupprogram.program_id = program.program_id');
        $builder->where('usersgroupprogram.users_id', $users_id);
        $builder->where('usersgroupprogram.program_id', $program_id);

        return $builder->get()->getRowArray();

    }

    public function getUserProgram($userId)
    {
        return $this->db->table('usersgroupprogram a')
            ->select("
                a.group_id,
                b.username,
                a.users_id,
                b.fullname,
                c.program_id,
                d.name AS group_name,
                c.name AS program
            ")
            ->join('users b', 'a.users_id = b.users_id')
            ->join('program c', 'a.program_id = c.program_id')
            ->join('group d', 'a.group_id = d.group_id')
            ->where('a.users_id', $userId)
            ->get()
            ->getRowArray();
    }

}
