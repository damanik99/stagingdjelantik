<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\CounterModel;

class CustomModel extends Model
{

    public function setIdRandomString($model, $column, $string = '', $length, $type)
	{	
		if($type == "Number")
			$characters = '0123456789';
		if($type == "Letter")
			$characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
		if($type == "String")
			$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            
			
        $customstring = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $customstring .= $characters[rand(0, strlen($characters) - 1)];
        }
            
        $random = $string.$customstring;
        $this->_model = $this->db->table($model)->select('*')->where($column, $random)->get()->getResultArray();
        if($this->_model)
        {
            return $this->setIdRandomString($model, $column, $string, $length);
        }
        else
		{
            return $random;
        }
	}

    public function setCounterNumber($model, $column, $name)
	{
		$counterNumber = '';
        $getcounter = $this->db->table('counter')->select('*')->where('name', $name)->get()->getRow();
        // echo var_dump($name);exit;
		if($getcounter)
		{
			$date = date('Y-m-d H:i:s');
			$year = date('Y',strtotime($date));
			$month = date('m',strtotime($date));
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
			
			$counterNumber = $name.$year.$month.$cntr;
            $dataCounter = $this->db->table('counter')->select('*')->where('counter_id', $getcounter->counter_id)->get()->getRow();
			
            $nm = $dataCounter->counter;
            
			$update_counter = new counterModel();
			if($dataCounter)
			{
				$updatecounter = [
					'counter' => $nm+1,
				];
				$this->db->table('counter')->where('counter_id', $dataCounter->counter_id)->update($updatecounter);
			}
		}
		
		$check = $this->db->table($model)->select('*')->where($column, $counterNumber)->get()->getRow();
		
		if($check)
		{
			return $this->setCounterNumber($model, $column, $name);
		}
		else
		{
			return $counterNumber;
		}
	}

	public function getClusterUsers($users_id, $program_id = "")
	{
		$token_key = array();
		
		$sql = '
			SELECT users_id FROM clusterusers a JOIN cluster b on a.cluster_id = b.cluster_id
			WHERE a.cluster_id IN (
				SELECT cluster_id FROM clusterusers
				WHERE users_id = '.$users_id.'
			) AND b.program_id = '.$program_id.'
			GROUP BY users_id
		';

		$query  = $this->db->query($sql);
		$dataProvider = $query->getResultArray();
		
		foreach($dataProvider as $i=>$ii)
		{	
			$token_key[] = $ii['users_id'];
		}
		
		return $token_key;	
	}
}