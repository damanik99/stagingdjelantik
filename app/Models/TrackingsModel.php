<?php namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\I18n\Time;

class TrackingsModel extends Model
{
    protected $table      = 'tracking';
    protected $primaryKey = 'tracking_id';

    // protected $allowedFields = ['usercode', 'username', 'password', 'active'];

    protected $useTimestamps = true;
    // protected $createdField  = 'created_date';
    // protected $updatedField  = 'modified_date';

    function queryRoute($username, $date)
    {
        $program_id = session()->get('program');
        $dates = date('Y-m-d', strtotime($date));
        // $today = Time::today('America/Chicago', 'en_US');
		$time = new Time($dates.'+1 day');
        $enddate = $time->toDateString();
        // echo var_dump($enddate);exit;
		$sql = 'SELECT latitude, longitude ';
		$sql .= 'FROM tracking a JOIN users b ON a.users_id = b.users_id ';
		$sql .= 'WHERE program_id = '.$program_id;
		$sql .= ' AND datetime >= "'.$dates.'" AND datetime < "'.$enddate.'" ';
		$sql .= ' AND b.username = "'.$username.'" ';
		$sql .= 'GROUP BY latitude, longitude ';
		$sql .= 'ORDER BY datetime ASC';

        $sql_first = 'SELECT latitude, longitude ';
		$sql_first .= 'FROM tracking a JOIN users b ON a.users_id = b.users_id ';
		$sql_first .= 'WHERE program_id = '.$program_id;
		$sql_first .= ' AND datetime >= "'.$dates.'" AND datetime < "'.$enddate.'" ';
		$sql_first .= ' AND b.username = "'.$username.'" ';
		$sql_first .= 'ORDER BY datetime ASC';

        $sql_last = 'SELECT latitude, longitude ';
		$sql_last .= 'FROM tracking a JOIN users b ON a.users_id = b.users_id ';
		$sql_last .= 'WHERE program_id = '.$program_id;
		$sql_last .= ' AND datetime >= "'.$dates.'" AND datetime < "'.$enddate.'" ';
		$sql_last .= ' AND b.username = "'.$username.'" ';
		$sql_last .= 'ORDER BY datetime DESC';

        // echo $sql;exit;
        $run = $this->db->query($sql);
        $runFirts = $this->db->query($sql_first);
        $runLast = $this->db->query($sql_last);

        return $run->getResultArray();
        return $runFirts->getResultArray();
        return $runLast->getResultArray();
    }

}