<?php namespace App\Controllers;

use CodeIgniter\I18n\Time;
use App\Models\UsersGroupProgramModel;
use App\Models\ShipmentModel;
use App\Models\DashboardModel;

use DateTime;

class DashBoard extends BaseController
{
    protected UsersGroupProgramModel $usersGroupProgram;
    protected ShipmentModel $shipmentModel;

    public function __construct()
    {
        helper('period');
        $session = \Config\Services::session();
        if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->usersGroupProgram = new UsersGroupProgramModel();
        $this->shipmentModel = new ShipmentModel();

        helper(['url', 'form']);
    }

    public function index()
    {
        $programId = session()->get('program');
        $usersId = session()->get('users_id');
        $groupName = $this->usersGroupProgram->getUserProgram($usersId);

        if (strtolower($groupName['group_name']) == 'driver') {

            $users_id = session()->get('users_id');
            
            $driverId = $this->db->table('driver a')
                ->select("a.driver_id")
                ->join('users b', 'a.users_id = b.users_id')
                ->where('a.users_id', $users_id)
                ->get()
                ->getRow();

            // if (!$driverId) {
            //     $this->session->setFlashdata('message', '<div class="alert alert-danger" role="alert">
            //     Akun Driver Tidak Terdaftar</div>');
            //     return redirect()->to('/auth/');
            // }
            $shipment = $this->shipmentModel->getActiveShipmentDriver($driverId->driver_id);
            
            $data = [
                'title' => 'Home',
                'programId' => $programId,
                'shipment' => $shipment
                
            ];

            echo view('/driver/home', $data);

        }  else {

            $data = [
                'title' => 'Home',
                'programId' => $programId,
            ];
            echo view('/dashboard/dashboard', $data);

        }

    }

    public function menuprivilage()
    {

        $programId      = $this->request->getPost('programid');
        $programName    = $this->request->getPost('programname');

        $is_programid = isset($programId) ? $programId : '';
        session()->set('program',$is_programid);
        session()->set('nameprogram', $programName);
        echo json_encode($programName);
	    return ;
    }
    
    public function driver()
    {
        $shipmentModel = new \App\Models\ShipmentModel();
        $driverId = session()->get('title');
        $data['shipment'] = $shipmentModel->getActiveShipmentDriver($driverId);
        
        return view('driver/home', $data);
    }

}
