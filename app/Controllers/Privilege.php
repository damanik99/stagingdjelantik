<?php

namespace App\Controllers;
use App\Models\PrivilegeModel;
use App\Models\DatalistModel;
use App\Models\SaveModel;

class Privilege extends BaseController
{
	protected PrivilegeModel $privilegeModel;
	protected DatalistModel $datalistModel;

	public function __construct()
	{
		$session = \Config\Services::session();
        if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

		$this->privilegeModel = new PrivilegeModel();
		$this->datalistModel = new DatalistModel();
	}

	public function datatables()
	{
		$request = service('request');
		$program_id = session()->get('program');

		$draw   = $request->getPost('draw');
		$start  = $request->getPost('start');
		$length = $request->getPost('length');
		$search = $request->getPost('search')['value'];

		$program_id = session()->get('program');

		// Base Query
		$baseQuery = "
			FROM privilege a
			JOIN `group` b ON a.`group_id` = b.`group_id`
			JOIN page c ON a.`page_id` = c.`page_id`
			JOIN `action` d ON a.`action_id` = d.`action_id`
			LEFT JOIN groupplan e ON b.`groupplan_id` = e.`groupplan_id`";

		// Filtering
		$filter = "";
		$params = [];
		if (!empty($search)) {
			$filter = " AND (
                b.name LIKE ? OR 
                c.name LIKE ? OR
                d.name LIKE ? OR 
                e.name LIKE ?
			)";
			for ($i = 0; $i < 4; $i++) $params[] = "%$search%";
		}

		// Total records
		$totalRecords = $this->db->query("SELECT COUNT(*) as cnt $baseQuery")->getRow()->cnt;
    
		$totalFiltered = $totalRecords;
		if (!empty($search)) {
			$totalFiltered =   $this->db->query("SELECT COUNT(*) as cnt $baseQuery $filter", $params)->getRow()->cnt;
		}

		$orderColumn = ['b.name', 'c.name', 'd.name', 'e.name']; // Sesuaikan dengan kolom
		$orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';
		$orderBy = $orderColumn[$request->getPost('order')[0]['column']] ?? 'a.created_date';

		// Data query
		$sql = "SELECT b.name AS 'group', c.name AS page, d.name AS 'actions', e.`name` AS groupplan, a.created_date, a.privilege_id
		$baseQuery $filter 
		ORDER BY $orderBy $orderDirection
		LIMIT ?, ?";
			
		$params[] = (int)$start;
		$params[] = (int)$length;
		$query = $this->db->query($sql, $params);
		$data = [];
        // echo var_dump($query);exit;
		foreach ($query->getResultArray() as $row)
		{
			$row['action'] = '
                <a href="' .base_url() . '/privilege/edit/' . $row['privilege_id']. '" class="badge badge-pill badge-success" title="Edit"><i class="fa fa-pencil"></i></a>
            ';
			$data[] = $row;
		}

		// Return in DataTables format
		return $this->response->setJSON([
			"draw" => intval($draw),
			"recordsTotal" => $totalRecords,
			"recordsFiltered" => $totalFiltered,
			"data" => $data
		]);
	}
	
	public function index()
	{
		$program_id = session()->get('program');
		$privilege = $this->privilegeModel->index($program_id);
		$group = $this->datalistModel->dataGroup($program_id);
		$page = $this->datalistModel->dataPage();
        $action = $this->datalistModel->dataAction();
		// echo var_dump($privilege);exit;
		$data = [
			'title'     => 'Privilege',
			'privilege' => $privilege,
			'group' => $group,
			'page' => $page,
            'action' => $action
		];

		return view('privilege/index', $data);
	}

	public function create()
	{
		$program_id = session()->get('program');
		$group = $this->privilegeModel->group($program_id);
		$page = $this->datalistModel->dataPage();
		$action = $this->datalistModel->dataAction();
		
		if($this->request->getMethod() == 'post')
		{
			
		}

		$data = [
			'title' => 'Form Create privilege',
			'group' => $group,
			'page' => $page,
			'action' => $action
		];

		return view('privilege/add', $data);
	}

	//--------------------------------------------------------------------

}