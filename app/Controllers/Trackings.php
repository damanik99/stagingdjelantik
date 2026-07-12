<?php

namespace App\Controllers;

use App\Models\UsersModel;
use App\Models\TrackingsModel;
use CodeIgniter\I18n\Time;

class Trackings extends BaseController
{
    protected $userModel;
    protected $trackingsModel;
    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }
        $this->userModel = new UsersModel();
        $this->trackingsModel = new TrackingsModel();
        helper(['url', 'form']);
    }

    public function index()
    {
        $username = $this->userModel->index();
        $data = [
            'title' => 'Tracking',
            'username'  => $username
        ];
        echo view('tracking/index', $data);
    }

    public function showRoute()
    {
        $username = $this->request->getPost('username');
        $date = $this->request->getPost('date');

        $program_id = session()->get('program');
        $dates = date('Y-m-d', strtotime($date));
        // $today = Time::today('America/Chicago', 'en_US');
        $time = new Time($dates.'+1 day');
        $enddate = $time->toDateString();
        // echo var_dump($enddate);exit;
        $sql = 'SELECT latitude, longitude, `location` ';
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

        $run = $this->db->query($sql);
        $runFirts = $this->db->query($sql_first);
        $runLast = $this->db->query($sql_last);

        $runsql = $run->getResultArray();
        $first = $runFirts->getResultArray();
        $last = $runLast->getResultArray();
        // echo var_dump($last);exit;

        $coor = array();
        $firstx = "";
        $lastx = "";
        $count = 0;
        foreach ($runsql as $i => $ii) {
            if ($count != 0 && $count != 22) {
                $coor[] = array(
                    'lat' => (float)$ii['latitude'],
                    'long' => (float)$ii['longitude'],
                    'loc' => $ii['location'],
                );
            }
            $count++;
        }
        // echo var_dump($coor[0]['location']);exit;
        foreach ($first as $i => $ii) {
            $firstx = (float)$ii['latitude'].", ".(float)$ii['longitude'];
        }

        foreach ($last as $i => $ii) {
            $lastx = (float)$ii['latitude'].", ".(float)$ii['longitude'];
        }
        // echo var_dump($last);exit;
        $array = array(
            'first' => $firstx,
            'last' => $lastx,
            'wayspoint' => $coor
        );
        echo json_encode($array);
        return;
        // $resultQuery = $this->trackingsModel->queryRoute($username, $date);

        // echo var_dump($last);exit;
    }
}
