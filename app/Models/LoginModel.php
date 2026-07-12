<?php
namespace App\Models;
use CodeIgniter\Model;
 
class LoginModel extends Model
{
    protected $table      = 'users';
    protected $primaryKey = 'users_id';

    protected $allowedFields = ['usercode', 'username', 'password'];

    public function getUser($username)
    { 
        $sql    = "SELECT * FROM users WHERE username='$username'";
        $query  = $this->db->query($sql);
        $result = $query->getRowArray();
        return $result;    
    }

    public function getUserPrograms($userId)
    {
        return $this->db->table('usersgroupprogram a')
            ->select("
                b.username,
                a.users_id,
                b.fullname,
                c.program_id,
                d.name AS role_name,
                c.name AS program
            ")
            ->join('users b', 'a.users_id = b.users_id')
            ->join('program c', 'a.program_id = c.program_id')
            ->join('group d', 'a.group_id = d.group_id')
            ->where('a.users_id', $userId)
            ->get()
            ->getRowArray();
    }
    
    public function getUserProgram($userid)
    { 
        $sql    = "SELECT * FROM users a,usersgroupprogram b,program c,devloyalty.group d
                   where a.users_id=b.users_id and b.program_id=c.program_id and b.group_id=d.group_id and a.users_id='$userid' group by b.program_id order by c.name ASC";
        $query  = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;    
    }
   
}