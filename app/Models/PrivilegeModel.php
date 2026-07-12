<?php namespace App\Models;

use CodeIgniter\Model;

class PrivilegeModel extends Model
{
    protected $table      = 'outbound';
    protected $primaryKey = 'outbound_id';

    protected $useAutoIncrement = true;
    protected $allowedFields = ['privilege_id', 'group_id', 'page_id', 'action_id', 'created_date', 'modified_date', 'created_by', 'modified_by'];

    // protected $useTimestamps = true;
    // protected $createdField  = 'created_date';
    // protected $updatedField  = 'modified_date';

    function index($id)
    {
        $privilege = $this->db->query(
            'SELECT privilege_id, b.`name` AS group_name, c.name AS page_name, d.name AS action_name FROM privilege a
            JOIN `group` b ON a.`group_id` = b.`group_id`
            JOIN page c ON a.`page_id` = c.`page_id`
            JOIN `action` d ON a.`action_id` = d.`action_id`
            JOIN groupprogram e ON b.`group_id` = e.`group_id`
            WHERE e.program_id = "'.$id.'"
            ORDER BY a.group_id, a.page_id, a.action_id ASC'
        );

        return $privilege->getResultArray();
    }

    function group($id)
    {
        $group = $this->db->query(
            'SELECT a.group_id, b.name AS group_name, a.`program_id`, c.name AS program_name FROM groupprogram a
            JOIN `group` b ON a.`group_id` = b.`group_id`
            JOIN program c ON a.`program_id` = c.`program_id`
            WHERE a.program_id = "'.$id.'" 
            ORDER BY b.name ASC'
        );

        return $group->getResultArray();
    }
}