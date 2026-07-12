<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MenusModel;

class Menus extends BaseController
{
    protected MenusModel $menusModel;
    
    public function __construct()
    {
        $session = \Config\Services::session();
        if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

		$this->menusModel = new MenusModel();
        log_message('error', 'Controller index method is called');
    }

    

    public function index()
    {
        $program = session()->get('program');

        return view('menus/index');
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
			FROM menu a
            JOIN page b ON a.`page_id` = b.`page_id`
            JOIN `action` c ON a.`action_id` = c.action_id
            LEFT JOIN menu d ON a.`parent_id` = d.`menu_id`";

		// Filtering
		$filter = "";
		$params = [];
		if (!empty($search)) {
			$filter = " AND (
                d.name LIKE ? OR 
                b.name LIKE ? OR 
                c.name LIKE ? OR 
                a.sequence LIKE ? OR 
                a.created_date LIKE ?
			)";
			for ($i = 0; $i < 5; $i++) $params[] = "%$search%";
		}

		// Total records
		$totalRecords = $this->db->query("SELECT COUNT(*) as cnt $baseQuery")->getRow()->cnt;
    
		$totalFiltered = $totalRecords;
		if (!empty($search)) {
			$totalFiltered =   $this->db->query("SELECT COUNT(*) as cnt $baseQuery $filter", $params)->getRow()->cnt;
		}

		$orderColumn = ['b.name', 'b.name', 'c.name', 'a.sequence', 'a.created_date']; // Sesuaikan dengan kolom
		$orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';
		$orderBy = $orderColumn[$request->getPost('order')[0]['column']] ?? 'a.created_date';

		// Data query
		$sql = "SELECT d.name AS parent, b.name AS page, c.name AS `actions`, a.sequence, a.created_date, a.menu_id
		$baseQuery $filter 
		ORDER BY $orderBy $orderDirection
		LIMIT ?, ?";

		$params[] = (int)$start;
		$params[] = (int)$length;
		$query = $this->db->query($sql, $params);
		$data = [];
        
		foreach ($query->getResultArray() as $row) {
			$row['action'] = '
                <a href="' . base_url() . '/menu/edit/' . $row['menu_id'] . '" class="badge badge-pill badge-success" title="Edit"><i class="fa fa-pencil"></i></a>
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

    public function checkSequence()
    {

        $parent = $this->request->getPost('parent');

        $db = db_connect();

        $used = $db->query("
            SELECT sequence 
            FROM menu 
            WHERE parent_id = (
                SELECT menu_id FROM menu WHERE name=?
            )
        ",[$parent])->getResultArray();


        $usedSeq = array_column($used,'sequence');

        $available=[];

        for($i=1;$i<=10;$i++){

            if(!in_array($i,$usedSeq)){
                $available[]=$i;
            }

        }

        return $this->response->setJSON([
            'available'=>$available
        ]);

    }

    public function create()
    {
        $parents = $this->menusModel->getListparentmenu();
        $pages = $this->menusModel->getListpage();
        $actions = $this->menusModel->getListaction();

        if($this->request->getMethod() == 'post') 
        {
            $menu      = $this->request->getPost('menu');
            $parent_id = $this->request->getPost('parent_id');
            $page_id   = $this->request->getPost('page');
            $action_id = $this->request->getPost('action');
            $sequence  = $this->request->getPost('sequence');
            $image_url = $this->request->getPost('image_url');
            // echo var_dump($action_id);exit;
            $db = db_connect();

            $db->table('menu')->insert([

                'name' => $menu,
                'parent_id' => $parent_id ?: NULL,
                'page_id' => $page_id,
                'action_id' => $action_id,
                'sequence' => $sequence,
                'image_url' => $image_url,
                'created_date' => date('Y-m-d H:i:s')

            ]);

            return $this->response->setJSON([

                'status'=>'success',
                'message'=>'Menu berhasil dibuat'

            ]);
        }

        $data = [
            'parents'=>$parents,
            'pages'=>$pages,
            'actions'=>$actions
        ];

        echo view('/menus/create', $data);
    }

    public function createPage()
    {
        $createdby  = session()->get('users_id');
        $page = $this->request->getPost('page');

        $db = db_connect();

        $exist = $db->table('page')
                    ->where('name',$page)
                    ->get()
                    ->getRow();

        if($exist){

            return $this->response->setJSON([
                'status'=>'exist'
            ]);

        }

        $db->table('page')->insert([

            'name' => $page,
            'created_date'=> date("Y-m-d H:i:s"),
            'modified_date'=> date("Y-m-d H:i:s"),
            'created_by' => $createdby

        ]);

        $id = $db->insertID();

        return $this->response->setJSON([

            'status'=>'success',
            'name'=>$page,
            'page_id'=>$id

        ]);

    }
}