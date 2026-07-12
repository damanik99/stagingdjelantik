<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\Counter;

class DatalistModel extends Model
{
    function getCounter($name)
    { 
            $sql  = 'SELECT name, counter_id, counter FROM counter WHERE name="'.$name.'"';
            $query = $this->db->query($sql);
            $result = $query->getRow();
            return $result;
    }

    function setCounterNumber($model, $column, $name)
	{
        $counterNumber = '';
        $getcounter = $this->getCounter($name);
        // echo var_dump($getcounter);exit;
		if($getcounter)
		{
            $date = date('Y-m-d H:i:s');
			$year = date('Y',strtotime($date));
			$month = date('m',strtotime($date));
            $dates = date('d',strtotime($date));
			$cntr = "";
			if(strlen($getcounter->counter) == 1)
            $cntr = '0000'.$getcounter->counter;
			if(strlen($getcounter->counter) == 2)
            $cntr = '000'.$getcounter->counter;
			if(strlen($getcounter->counter) == 3)
            $cntr = '00'.$getcounter->counter;
            if(strlen($getcounter->counter) == 4)
            $cntr = '0'.$getcounter->counter;
            if(strlen($getcounter->counter) >= 5)
            $cntr = $getcounter->counter;
            
            $data  = array(
                'counter' => $getcounter->counter + 1,
                
            );
			$counterNumber = $name.$year.$month.$dates.$cntr;
            // echo var_dump($counterNumber);exit;
            
            $db = \Config\Database::connect();
            $builder = $db->table('counter');
            $builder->set('counter', $data['counter']);
            $builder->where('counter_id', $getcounter->counter_id);
            $builder->update($data);

            // $check = $model::model()->findByAttributes(array($column=>$counterNumber));
            
            $db = \Config\Database::connect();
            $builder = $db->table($model);
            $builder->where($column, $counterNumber);
            $check = $builder->get()->getRow();
            if($check)
            {
                return $this->setCounterNumber($model, $column, $name);
            }
            else
            {
                return $counterNumber;
            }
		}
	}

    function dataGroup($program_id)
    {

        $sql = 'SELECT a.group_id, b.name AS group_name FROM groupprogram a
        JOIN `group` b ON a.`group_id` = b.group_id
        JOIN program c ON a.`program_id` = c.`program_id`
        WHERE a.program_id ="'.$program_id.'"';
        
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        
        return $result;
    }

    function dataPage()
    {
        $query   = $this->db->query('SELECT * FROM page ORDER BY `name` ASC');
        $results = $query->getResultArray();

        return $results;

    }

    function dataAction()
    {
        $query   = $this->db->query('SELECT * FROM action');
        $results = $query->getResultArray();

        return $results;

    }

    function SellingType($name)
	{
        $db = \Config\Database::connect();
        $program_id = session()->get('program');

        $builder = $db->table('sellingtype');
        $builder->where('name', $name);
        $builder->where('program_id', $program_id);
        return $builder->get()->getRow();
	}

    function dataGroupplan()
    {
        $query   = $this->db->query('SELECT * FROM groupplan');
        $results = $query->getResultArray();

        return $results;

    }

    
}