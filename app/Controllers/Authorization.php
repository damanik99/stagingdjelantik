<?php

namespace App\Controllers;
use App\Models\AuthorizationModel;

class Authorization extends BaseController
{
	protected $menuModel;

	public function __construct()
	{
		//$this->authorizationModel = new AuthorizationModel();
	}
	
	public function index()
	{
		$db = \Config\Database::connect();
		$authorization = $db->query("SELECT a.users_group_program_id,b.username,c.name AS groups,d.name AS programname,a.data_level,DATE(a.created_date) AS created_date
                                            FROM usersgroupprogram a,users b,`group` c,program d WHERE a.users_id=b.users_id 
                                            AND a.group_id=c.group_id AND a.program_id=d.program_id ORDER BY DATE(a.created_date) DESC")->getResultArray();
		$data = [
			'title'         => 'Authorization',
			'authorization' => $authorization
		];

		return view('authorization/index', $data);
	}
        
        

	public function create()
	{
		$data = [
			'title' => 'Form Create authorization',
		];

		return view('authorization/create', $data);
	}

	//--------------------------------------------------------------------

}
