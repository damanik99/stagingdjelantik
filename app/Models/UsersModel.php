<?php

namespace App\Models;

use CodeIgniter\Model;

class UsersModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'users_id';

    protected $allowedFields = [
        'username',
        'password',
        'fullname',
        'phone',
        'email',
        'city_id',
        'district_id',
        'village_id',
        'province_id',
        'address',
        'title',
        'driver_type',
        'active',
        'created_date',
        'modified_date',
        'created_by',
        'modified_by'
    ];

    public function getgroupProgram()
    {
        $program_id = session()->get('program');
        $result = $this->db->table('groupprogram a')
            ->select("
                a.group_program_id AS group_id,
                CONCAT(b.name, ' - ', c.name) AS title, b.name AS group
            ")
            ->join('group b', 'a.group_id = b.group_id')
            ->join('program c', 'a.program_id = c.program_id')
            ->where('a.program_id', $program_id)
            ->orderBy('b.name', 'ASC')
            ->get()
            ->getResultArray();

        return $result;
    }

    public function dataUsers($id) 
    {
        $program = session()->get('program');
        $data = $this->db->table('usersgroupprogram a')
                ->select('us.*, b.provinsi, c.kecamatan, d.kelurahan, g.group_id, g.name AS group, a.data_level, kt.kabupaten_kota')
                ->join('users us', 'a.users_id = us.users_id', 'left')
                ->join('tbl_provinsi b', 'us.province_id = b.id', 'left')
                ->join('tbl_kecamatan c', 'us.district_id = c.id', 'left')
                ->join('tbl_kelurahan d', 'us.village_id = d.id', 'left')
                ->join('tbl_kabkot kt', 'us.city_id = kt.id')
                ->join('group g', 'a.group_id = g.group_id')
                ->where('us.users_id', $id)
                ->where('a.program_id', $program)
                ->get()->getRowArray();

        return $data;

    }
}