<?php namespace App\Models;

use CodeIgniter\Model;

class MenusModel extends Model
{
    protected $table      = 'menu';
    protected $primaryKey = 'menu_id';

    protected $allowedFields = [
        'name', 'page_id', 'action_id', 'description', 'sequence', 'image_url', 'created_date',
        'modified_date', 'created_by', 'modified_by'
    ];

    public function selectProgram()
    {
        $users_id = session()->get('users_id');
        $admin = session()->get('first_name');
        
        $sql = "SELECT b.program_id, b.name as program_name FROM usersgroupprogram a
            JOIN program b ON a.program_id = b.program_id
            JOIN users c ON a.users_id = c.users_id
            JOIN `group` d ON a.group_id = d.group_id";

        if ($admin !='Super Admin')
        {
            $sql .= " WHERE  a.users_id ='".$users_id."'";
        }

        $sql .= " GROUP BY b.program_id ORDER BY d.name ASC";

        $query = $this->db->query($sql);
        $result = $query->getResultArray();

        return $result;
    }

    public function getListparentmenu()
    {
        return $this->db->query("SELECT * FROM menu WHERE parent_id IS NULL OR parent_id =' '")->getResultArray();
    }
    
    public function getListpage()
    {
        return $this->db->query(" SELECT * FROM `page` ORDER BY NAME ASC ")->getResultArray();
    }
    
    public function getListaction()
    {
        return $this->db->query(" SELECT * FROM `action` ORDER BY NAME ASC ")->getResultArray();
    }
}

 