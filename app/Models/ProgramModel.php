<?php namespace App\Models;

use CodeIgniter\Model;

class ProgramModel extends Model
{
    protected $table            = 'program';
    protected $primaryKey       = 'program_id';
    protected $useAutoIncrement = true;

    protected $allowedFields = ['client_id', 'status_id', 'handling_charge_d', 'code', 'name_program', 'contact_name', 'contact_email', 
    'contact_phone', 'start_date', 'finish_date', 'end_date', 'budget', 'time_start', 'time_stop', 'frequency', 'include_saturday',
    'include_sunday', 'module_attendance', 'module_redemption', 'module_activity', 'module_distribution', 'module_display',
    'module_selling', 'module_salesclaim', 'module_training', 'module_inbound', 'created_date', 'modified_date', 'created_by', 'modified_by'];

    // protected $useTimestamps = true;
    // protected $createdField  = 'created_date';
    // protected $updatedField  = 'modified_date';

    function index($id = false)
    {
        if($id == false) 
        {
            // echo var_dump($id);exit;
            $program_id = session()->get('program');
    
            $builder = $this->db->table('program');
            $builder->select('program_id, program.code, program.name AS program_name, status.name AS status, client.company AS company, status.name AS status_name, 
            module_attendance, module_redemption, module_activity, module_distribution, module_display, module_selling, module_salesclaim, module_training, module_inbound');
            $builder->join('client', 'program.client_id = client.client_id');
            $builder->join('status', 'program.status_id = status.status_id');
            $builder->orderBy('program.name', 'ASC');
            // echo var_dump($builder->get()->getResultArray());exit;
            return $builder->get()->getResultArray();
        }
        else
        {
            $query = $this->db->query('
                SELECT *,a.code, a.name AS program, a.start_date AS start_date, a.program_id, b.company AS client_name, c.`name` AS status_name, 
                d.name AS handling, d.handling_charge_id, a.contact_name, module_selling, module_redemption, module_activity, module_distribution, 
                module_display, module_selling, module_salesclaim, module_training, module_inbound
                FROM program a
                JOIN `client` b ON a.`client_id` = b.`client_id`
                JOIN `status` c ON a.`status_id` = c.`status_id`
                JOIN handlingcharge d ON a.handling_charge_id = d.handling_charge_id
                WHERE program_id = "'.$id.'"
            ');

            return $query->getResultArray();
        }
    }

    public function handling()
    {
        $query = $this->db->query('
                SELECT * FROM handlingcharge
            ');

            return $query->getResultArray();
    }

}