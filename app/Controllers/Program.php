<?php

namespace App\Controllers;
use App\Models\ProgramModel;
use App\Models\StatusModel;
use App\Models\ClientModel;

class Program extends BaseController
{
	protected $menuModel;

	public function __construct()
	{
		$session = \Config\Services::session();
		if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }
		$this->programModel = new ProgramModel();
		$this->statusModel = new StatusModel();
		$this->clientModel = new ClientModel();
	}
	
	public function index()
	{
		// $db = \Config\Database::connect();
		$program = $this->programModel->index();
		$data = [
			'title'   => 'Program',
			'program' => $program
		];
		return view('program/index', $data);
	}    

	public function create()
	{
		$data = [
			'title' => 'Create Program',
		];

		return view('program/create', $data);
	}

	public function edit($id)
	{   
		$data = $this->programModel->index($id);
		$handling = $this->programModel->handling();
		$status = $this->db->table('status')->like('code', 'PRGM_')->get()->getResultArray();
		$client = $this->clientModel->dataClient();
		// echo var_dump($data);exit;
		$data = [
			'title'    => 'Program Update',
			'data'     => $data,
			'handling' => $handling,
			'status'   => $status,
			'client'   => $client
		];

		// echo var_dump($data['data']);exit;

		return view('/program/edit', $data);
	}

	public function saveedit($id)
	{
		$model = new ProgramModel();
		$createdby  = session()->get('users_id');
        $program_id = session()->get('program');
		// echo var_dump($this->request->getPost('client'));exit;
		$model->update($id, [
			'client_id'          	=> $this->request->getPost('client'),
			'contact_name'	  		=> $this->request->getPost('contact_name'),
			'contact_email'	  		=> $this->request->getPost('contact_email'),
			'contact_phone'	  		=> $this->request->getPost('contact_phone'),
			'code'	  		  		=> $this->request->getPost('code'),
			'name'	  				=> $this->request->getPost('name_program'),
			'start_date'	  		=> $this->request->getPost('start_date'),
			'end_date'	      		=> $this->request->getPost('contact_phone'),
			'budget'	  	  		=> $this->request->getPost('budget'),
			'handling_charge_id'	=> $this->request->getPost('handling_charge_id'),
			'status_id'	  			=> $this->request->getPost('status_id'),
			'time_start'	  		=> $this->request->getPost('time_start'),
			'time_stop'	  			=> $this->request->getPost('time_stop'),
			'frequency'	  			=> $this->request->getPost('frequency'),
			'include_saturday'	    => $this->request->getPost('include_saturday'),
			'include_sunday'	    => $this->request->getPost('include_sunday'),
			'module_attendance'	    => $this->request->getPost('module_attendance'),
			'module_redemption'	    => $this->request->getPost('module_redemption'),
			'module_activity'	    => $this->request->getPost('module_activity'),
			'module_distribution'	=> $this->request->getPost('module_distribution'),
			'module_display'	    => $this->request->getPost('module_display'),
			'module_selling'	    => $this->request->getPost('module_selling'),
			'module_salesclaim'	    => $this->request->getPost('module_salesclaim'),
			'module_training'	    => $this->request->getPost('module_training'),
			'module_inbound'	    => $this->request->getPost('module_inbound'),
			'modified_date'			=> date("Y-m-d H:i:s"),
			'modified_by' 			=> $createdby
		
		]);

		// echo var_dump($this->request->getPost('module_attendance'));exit;
		session()->setFlashdata('success', 'Data berhasil di Update');
        return redirect()->to('/program/index');
	}

	public function view($id)
	{
		$views = $this->programModel->index($id);
		
		$data = [
			'title'  => 'view',
			'views'  => $views,
		];

		return view('/program/view', $data);
	}
}