<?php 

namespace App\Controllers;
use App\Models\RedemptionModel;
use App\Models\MemberModel;
use App\Models\StatusModel;
use App\Models\ImportCsvFormModel;
use App\Models\CustomModel;
use App\Models\RedemptionhistoryModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Redemption extends BaseController
{
	protected $redemptionModel;

	public function __construct()
    {
		// parent::__construct();
		$session = \Config\Services::session();
		if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }
        helper(['url', 'form']);
		$this->redemptionModel = new RedemptionModel();
		$this->memberModel = new MemberModel();
		$this->statusModel = new StatusModel();
        $this->redemptionhistoryModel = new RedemptionhistoryModel();
	}
	
	public function index()
	{
		$data = $this->redemptionModel->index();
		
		$data = [
			'title' => 'Redemption',
			'data' => $data
		];
		echo view('redemption/index', $data);
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
        $baseQuery = "FROM redemption a 
            JOIN `status` b ON a.`status_id` = b.`status_id`
            LEFT JOIN member c ON a.`member_id` = c.`member_id`
            JOIN programitem d ON a.`program_item_id` = d.`program_item_id`
            JOIN item e ON d.`item_id` = e.`item_id`
            WHERE d.program_id = ?";

        // Filtering
        $filter = "";
        $params = [$program_id];
        if (!empty($search)) {
            $filter = " AND (
                a.tracking_number LIKE ? OR 
                c.first_name LIKE ? OR 
                e.name LIKE ? OR 
                b.name LIKE ? OR 
                a.delivery_order LIKE ?
            )";
            for ($i = 0; $i < 5; $i++) $params[] = "%$search%";
        }

        // Total records
        $totalRecords = $this->db->query("SELECT COUNT(*) as cnt $baseQuery", [$program_id])->getRow()->cnt;
        $totalFiltered = $totalRecords;
        if (!empty($search)) {
            $totalFiltered =   $this->db->query("SELECT COUNT(*) as cnt $baseQuery $filter", $params)->getRow()->cnt;
        }

        $orderColumn = ['a.tracking_number', 'c.first_name', 'e.name', 'b.name', 'a.quantity', 'a.delivery_order']; // Sesuaikan dengan kolom
        $orderDirection = $request->getPost('order')[0]['dir'] ?? 'ASC';
        $orderBy = $orderColumn[$request->getPost('order')[0]['column']] ?? 'a.created_date';

        // Data query
        $sql = "SELECT a.redemption_id, a.tracking_number, c.first_name AS member_name, e.name AS item_name, 
                a.quantity, b.name AS status_name, a.code AS redemption_code, 
                c.company_name, e.code AS sku, a.approved, 
                a.point_redemp, a.courier, a.delivery_order AS noref, a.receive_by, a.pod, 
                a.note1, a.note2, a.note3, a.created_date AS createddate
                $baseQuery $filter 
                ORDER BY $orderBy $orderDirection
                LIMIT ?, ?";
        $params[] = (int)$start;
        $params[] = (int)$length;
        $query = $this->db->query($sql, $params);
        $data = [];
        foreach ($query->getResultArray() as $row) {
            $row['action'] = '
                <a href="'.base_url().'/redemption/edit/'.$row['redemption_id'].'" class="badge badge-pill badge-success" title="Edit"><i class="fa fa-pencil"></i></a>
                <a href="'.base_url().'/redemption/view/'.$row['redemption_id'].'" class="badge badge-pill badge-primary" title="Detail"><i class="fa fa-eye"></i></a>
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

	public function save()
	{		
		$model = new RedemptionModel();

		$status = $this->db->table('status')->select('*')->where('code', 'RDMP_OPEN')->get()->getRow();
		
		$model->insert([
			"tracking_number"   => $this->request->getPost('tracking_number'),
			"code" 				=> $this->request->getPost('redemption_code'),
			"status_id" 		=> $status->status_id,
			"member_id" 		=> $this->request->getPost('member_id'),
			"point_balance" 	=> $this->request->getPost('point_balance'),
			"point_redeem" 	    => $this->request->getPost('point_redeem'),
			"quantity_redeem" 	=> $this->request->getPost('quantity_redeem'),
			"note" 				=> $this->request->getPost('note'),
			"created_date" 		=> date("Y-m-d H:i:s"),
			'created_by'    	=> session()->get('users_id')
		]);

		session()->setFlashdata('success', 'Data berhasil di simpan');
        return redirect()->to('/redemption/add/');
	}

	public function get_member()
	{
		$value = $this->request->getPost('value');
        
		$sql  = "SELECT * FROM member
                WHERE code ='".$value."'";
        $query = $this->db->query($sql);
        $result = $query->getRowArray();
		  
        
		return json_encode($result);
	}

	public function redeemptionhistory($id)
	{
		$data = $this->redemptionModel->redemptionHistory($id);
		
		$data = [
			'title' 	=> 'Redeemption History',
			'data' 		=> $data
		];
		echo view('redemption/index_history', $data);
	}

	public function add()
	{
		$program_id = session()->get('program');
		
		$mcode = $this->memberModel->membercode($program_id);
		
		$data = [
			'title' 	=> 'REDEMPTION CREATE',
			'mcode' 	=> $mcode
		];

		echo view('/redemption/add', $data);
	}

    public function detail_ref($noref)
    {
        $program_id = session()->get('program');
        $data['title'] = 'Data History Tracking SAP';
        $url = "https://track.coresyssap.com/shipment/tracking/reference/?api_key=global&reference_no=" . $noref;

        $get_content = @file_get_contents($url); // Menambahkan @ untuk menekan error notice

        if ($get_content === FALSE) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'API is under maintenance, please try again later.'
            ]);
        } else {
            $data['view'] = json_decode($get_content, TRUE);
            if ($data['view'] == NULL) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Data Null'
                ]);
            } else {
                echo view('redemption/index_detail_ref', $data);
            }
        }
    }

    public function dataApi($noref)
    {
        $url = "http://track.coresyssap.com/shipment/tracking/reference/?api_key=global&reference_no=".$noref."";
        $get_content = file_get_contents($url);
        $get = json_decode($get_content);
        echo var_dump($get);exit;
        for ($i = 0; $i<count($get); $i++)
        {
            // for ($j = 0; $j < count($get[$i]); $j++) {
                // echo $arrayUtama[$i][$j] . " ";
            // }
        }
        
        return $get;

    }

	public function view($id)
	{
		if ($id == NULL) 
        {
            echo view('/supplier/forbidden');
        }
        else
        {
            $views = $this->redemptionModel->index($id);
            $data  = array(
                'title'    => 'VIEW',
                'views'     => $views
            );
            
            echo view('/redemption/view', $data);
        }
	}

	public function edit($id)
	{
		$dataredemption = $this->redemptionModel->index($id);
		$status = $this->redemptionModel->setStatus($id);
		
        $data = [
			'title'  => 'Edit',
            'views'  => $dataredemption,
			'status' => $status
		];
		
        return view('/redemption/edit', $data);
	}

	public function saveedit($id)
	{
		$createdby  = session()->get('users_id');
        
        $model = new RedemptionModel();

        $model->update($id, [
            "delivery_order"   => $this->request->getPost('delivery_order'),
            "status_id"        => $this->request->getPost('status'),
            "note1"            => $this->request->getPost('note1'),
            "created_date"     => date("Y-m-d H:i:s"),
            "modified_date"    => date("Y-m-d H:i:s"),
            "modified_by"      => $createdby
        ]);

        session()->setFlashdata('success', 'Data berhasil di Update');
        return redirect()->to('/Redemption');
	}

	public function downloadFile()
    {
        $path = $_SERVER['DOCUMENT_ROOT']. '\teamplate\assets\file\teamplate\template_redemption.csv';
        $data = file_get_contents($path); // Read the file's contents
        $name = "template_redemption.csv";

        return $this->response->download($name, $data);
    }

    public function upload()
	{	
		$data = [
			'title' => 'Upload',
		];
		
		echo view('redemption/upload', $data);
	}

    public function updateWrongProgram()
    {
        if($this->request->getMethod() == 'post')
        {
            $program_id  = session()->get('program');
            $createdby  = session()->get('users_id');
            
            $model = new ImportCsvFormModel();
            $file_csv = $this->request->getFile('fileexcel');
            
            $tempLoc = $file_csv->getTempName();
            
            if($tempLoc == "" || $tempLoc == NULL)
            {
                session()->setFlashdata('error', 'Invalid file, Please select the file');
                return redirect()->to('/redemption/upload');
            }
            
            $value = $model->arrayValue($tempLoc);
            $ext = $file_csv->getClientExtension();

            if($ext == 'csv')
            {
                if($program_id)
                {
                    $fields = array();
                    $returnMessage = array();
                    
                    for($r=0;$r<count($value);$r++)
                    {
                        $model_redemption = new RedemptionModel();
                        
                        $fields[] = array_keys($value[$r]);
                        $message = '';
                        
                        $program = $this->db->table('program')->select('*')->where('program_id', $program_id)->get()->getRow();
                        
                        for($p=0;$p<count($fields[$r]);$p++)
                        {
                            $field = trim($fields[$r][$p]);
                            
                            $values = $value[$r][$field];
                            
                            if($field == 'tracking_number')
                            {
                                if($values != "")
                                {
                                    $redemption = $this->db->table('redemption')->select('*')->where('tracking_number', $values)->get()->getRow();
                                    
                                    if($redemption)
                                    {
                                        $model_redemption->tracking_number = $redemption->tracking_number;
                                        $model_redemption->redemption_id = $redemption->redemption_id;
                                        
                                    }
                                    else
                                    {
                                        $message .= 'TRACKING NOT EXIST;';
                                    }
                                }
                                else
                                {
                                    $message .= 'TRACKING NUMBER EMPTY;';
                                }
                            }

                            if($field == 'member_code')
                            {
                                if($values != "")
                                {
                                    $member = $this->db->table('member')->select('*')->where('code', $values)->get()->getRow();
                                    if ($member) 
                                    {
                                        $model_redemption->member_id = $member->member_id;
                                    }
                                }
                                else
                                {
                                    $message .= 'MEMBER CODE EMPTY;';
                                }
                            }
                        }

                        if($message == '')
                        {
                            $program = $this->db->table('program')->select('*')->where('name', $value[$r]['program_name'])->get()->getRow();
                            
                            if($program)
                            {
                                $item = $this->db->table('item')->select('*')->where('code', $value[$r]['item_sku'])->get()->getRow();
                                $programitem = $this->db->table('programitem')->select('*')->where('program_id', $program->program_id)->where('item_id', $item->item_id)->get()->getRow();
                                $query = $this->db->query('SELECT a.member_id, c.first_name AS member_name
                                                        FROM programmember a
                                                        JOIN program b ON a.`program_id` = b.`program_id`
                                                        JOIN member c ON a.`member_id` = c.`member_id`
                                                        WHERE a.program_id = "'.$program->program_id.'" AND c.code = "'.$value[$r]['member_code'].'";');
                                $programmember = $query->getRow();
                                if ($programmember)
                                {
                                    $model_redemption->update($model_redemption->redemption_id, [
                                        "program_item_id" => $programitem->program_item_id,
                                        "member_id" => $programmember->member_id,
                                        "modified_date" => date("Y-m-d H:i:s"),
                                        "modified_by" => session()->get('users_id')
                                    ]);
                                    $message .= "SUCCESS";
                                }
                                else
                                {
                                    $message .= "MEMBER NAME AND PROGRAM NULL";
                                }
                            }
                            else
                            {
                                $message .= 'PROGRAM NAME EMPTY(the program name does not match, double check whether the program name is correct);';
                            }
                        }

                        $returnMessage[] = $message;
                    }

                    $file = 'updatewrongprogram_Result'.date('Y-m-d');
                    $data = $model->importCsv($value, $returnMessage);
                    header("Content-type: application/csv");
                    header("Content-Disposition: attachment; filename=\"$file".".csv\"");
                    header("Pragma: no-cache");
                    header("Expires: 0");
            
                    $output = fopen('php://output', 'w');
            
                    fputcsv($output, array('tracking_number', 'member_code', 'item_sku', 'program_name', 'result'));
            
                    foreach ($data as $data_array) {
                        fputcsv($output, $data_array);
                    }
                        fclose($output);
                    exit;
                }
                else
                {
                    session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Warning, Program Belum dipilih</div>');
                    return redirect()->to('/redemption/updatewrongprogram');
                }
            }
            else
            {
                session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Warning, No data in File or No File CSV</div>');
                return redirect()->to('/redemption/updatewrongprogram');
            }
        }

        $data = [
			'title' => 'Upload',
		];

        echo view('redemption/updatewrongprogram', $data);
    }

	public function uploadRedemption()
    {
        $replacement = $this->request->getPost('replaceexist');
        $program_id  = session()->get('program');
        $createdby  = session()->get('users_id');
        
        $model = new ImportCsvFormModel();
        $file_csv = $this->request->getFile('fileexcel');
        
        $tempLoc = $file_csv->getTempName();
        
        if($tempLoc == "" || $tempLoc == NULL)
        {
            session()->setFlashdata('error', 'Invalid file, Please select the file');
            return redirect()->to('/redemption/upload');
        }
        
        $value = $model->arrayValue($tempLoc);
        $ext = $file_csv->getClientExtension();

        if($ext == 'csv') 
        {
            if($program_id) 
            {
                $fields = array();
                $returnMessage = array();

                for($r=0;$r<count($value);$r++)
                {
                    $model_redemption = new RedemptionModel();
                    
                    $fields[] = array_keys($value[$r]);
                    $message = '';

                    $status_name = '';
                    $model_r = '';
                    $point_redeem = '';
                    // $updateFields = [];
                    
                    $program = $this->db->table('program')->select('*')->where('program_id', $program_id)->get()->getRow();

                    for($p=0;$p<count($fields[$r]);$p++)
                    {
                        $field = trim($fields[$r][$p]);
                        $values = $value[$r][$field];
                        $status_name = strtolower($value[$r]['redemption_status']);

                        if($field == 'tracking_number') 
                        {
                            if($replacement == "replaceexist")
                            {
                                $redemption = $this->db->table('redemption')->select('*')->where('tracking_number', $values)->get()->getRow();
                                if(!$redemption)
                                {
                                    $message .= 'TRACKING NUMBER EMPTY;';
                                }
                            }
                            
                            if($values != "") 
                            {
                                $redemption = $this->db->table('redemption')->select('*')->where('tracking_number', $values)->get()->getRow();
                                
                                if($redemption != "" || $redemption != NULL) 
                                {
                                    if($status_name == 'open')
                                    {
                                        $message .= 'TRACKING NUMBER EXIST;';
                                    }
                                    
                                    if($status_name == 'cancel')
                                    {
                                        $status = $this->db->table('status')->select('*')->where('status_id', $redemption->status_id)->get()->getRow();
                                        if($status->code != 'RDMP_OPEN')
                                            $message .= 'CAN NOT CANCEL;';
                                    }
                                }
                                else
                                {
                                    if($status_name == 'open')
                                        $model_redemption->tracking_number = $values;
                                    else
                                        $message .= 'TRACKING NUMBER NOREG STATUS NOT OPEN;';
                                }
                            }
                            else
                            {
                                $message .= 'TRACKING NUMBER EMPTY;';
                            }
                        }

                        if($field == 'user_id')
                        {
                            if($replacement == "replaceexist")
                            {
                                $member = $this->db->table('member')->select('*')->where('code', $values)->where('program_id', $program->program_id)->get()->getRow();
                                if($member == '' || $member == NULL)
                                    $message .= 'MEMBER NOREG;';
                                else
                                {
                                    $model_redemption->member_id = $member->member_id;
                                    // $updateFields[] = 'user_id';
                                }
                            }
                            
                            if($values != NULL || $values != "")
                            {
                                $member = $this->db->table('member')->select('*')->where('code', $values)->where('program_id', $program->program_id)->get()->getRow();

                                if($member != '' || $member != NULL)
                                    $model_redemption->member_id = $member->member_id;
                                else
                                {
                                    if($program->auto_membership == 1)
                                    {
                                        if($value[$r]['user_id'] != '' || $value[$r]['full_name'] != '' || $value[$r]['mobile_number'] != '' || $value[$r]['deliveryaddress1'] != '')
                                        {
                                            $m_member = new memberModel;

                                            $status = $this->db->table('status')->select('*')->where('code', 'MEMB_ACTIVE')->get()->getRow();
                                            $m_member->status_id = $status->status_id;

                                            if($value[$r]['city'] == '')
												$city = $this->db->table('city')->select('*')->where('name', 'None')->get()->getRow();
                                            else
                                            {
                                                $city = $this->db->table('city')->select('*')->where('name', $value[$r]['city'])->get()->getRow();
                                                
                                                if($city == '' || $city == NULL)
                                                {
                                                    $model_redemption->note1 = $value[$r]['city'];
                                                    $ccity = $this->db->table('city')->select('*')->where('name', 'none')->get()->getRow();
                                                    $m_member->city_id = $ccity->city_id;
                                                }
                                                else
                                                    $m_member->city_id = $city->city_id;
                                            }

                                            $m_member->program_id = $program->program_id;
                                            $m_member->code = $value[$r]['user_id'];
                                            $m_member->first_name = trim(preg_replace('/[^\w\s,.-]/', '', $value[$r]['full_name']));
                                            $m_member->company_name = $value[$r]['company_name'];
                                            $m_member->mobile_phone = $value[$r]['mobile_number'];
                                            $m_member->company_phone = $value[$r]['contact_phone'];
                                            $m_member->company_fax = $value[$r]['fax'];
                                            $m_member->personal_email = $value[$r]['email'];
                                            
                                            // Menghapus simbol dan spasi di depan dan belakang pada deliveryaddress1 dan deliveryaddress2
                                            $m_member->domicile_address = trim(preg_replace('/[^\w\s]/', '', $value[$r]['deliveryaddress1']));
                                            $m_member->company_address = trim(preg_replace('/[^\w\s]/', '', $value[$r]['deliveryaddress2']));
                                            
                                            $m_member->gender = "None";
                                            $m_member->state = $value[$r]['state'];
                                            $m_member->country = $value[$r]['country'];
                                            $m_member->postal_code = $value[$r]['postal_code'];

                                            $savemember = [
                                                'program_id'              => $m_member->program_id,
                                                'status_id'               => $m_member->status_id,
                                                'city_id'                 => $m_member->city_id,
                                                'code'                    => $m_member->code,
                                                'first_name'              => $m_member->first_name,
                                                'company_name'            => $m_member->company_name,
                                                'mobile_phone'            => $m_member->mobile_phone,
                                                'company_phone'           => $m_member->company_phone,
                                                'company_fax'             => $m_member->company_fax,
                                                'personal_email'          => $m_member->personal_email,
                                                'domicile_address'        => $m_member->domicile_address,
                                                'company_address'         => $m_member->company_address,
                                                'gender'                  => $m_member->gender,
                                                'state'                   => $m_member->state,
                                                'country'                 => $m_member->country,
                                                'postal_code'             => $m_member->postal_code,
                                                'created_date'            => date("Y-m-d H:i:s"),
                                                'modified_date'           => date("Y-m-d H:i:s"),
                                                'created_by'              => $createdby,
                                                'modified_by'             => $createdby,
                                            ];

                                            if($this->db->table('member')->insert($savemember))
                                            {
                                                $member_id = $this->db->insertID();
                                                $saveProgramMember = [
                                                    'program_id'    => $program_id,
                                                    'member_id'     => $member_id,
                                                    'status_id'     => $status->status_id,
                                                    'created_date'  => date("Y-m-d H:i:s"),
                                                    'modified_date' => date("Y-m-d H:i:s"),
                                                    'created_by'    => $createdby,
                                                    'modified_by'   => $createdby,
                                                ];

                                                $this->db->table('programmember')->insert($saveProgramMember);
                                            }

                                            $model_redemption->member_id = $member_id;
                                        }
                                        else
											$message .= 'MEMBER DATA NOT COMPLETE;';
                                    }
                                    else
                                        $message .= 'PROGRAM AUTO MEMBER NOREG;';
                                }
                            }
                            else
                                $message .= 'USER ID EMPTY;';
                        }

                        if($field == 'recipient_name')
                        {
                            // Menghapus spasi di depan dan belakang
                            $values = trim($values);
                            
                            // Menghapus spasi ganda (mengganti lebih dari satu spasi dengan satu spasi)
                            $values = preg_replace('/\s+/', ' ', $values);
                            
                            // Menghapus karakter spesial (selain huruf, angka, dan spasi)
                            $values = preg_replace('/[^a-zA-Z0-9\s]/', '', $values);

                            // Pastikan tidak ada spasi di akhir setelah karakter spesial dihapus
                            $values = trim($values);
                            
                            if($values != NULL && $values != "") 
                            {
                                $model_redemption->recipient_name = $values;
                            } 
                            else 
                            {
                                $message .= 'RECIPIENT NAME EMPTY;';
                            }
                        }

                        if($field == 'redemption_status') 
                        {
                            if($values != NULL || $values != "")
                            {
                                $values = str_replace(' ','_',$values);
                                
                                $status = $this->db->table('status')->select('*')->where('code', 'RDMP_'.$values)->get()->getRow();
                                
                                if($status != '' || $status != NULL)
                                    $model_redemption->status_id = $status->status_id;
                                else
                                    $message .= 'STATUS NOREG;';
                            }
                            else
                                $message .= 'STATUS EMPTY;';
                        }

                        if($field == 'item_sku')
                        {
                            if($values != NULL || $values != "")
                            {
                                $item = $this->db->table('item')->select('*')->where('code', $values)->get()->getRow();
                                if($item != NULL || $item != '')
                                {
                                    $prog_cat = $this->db->table('programitem')->select('*')->where('item_id', $item->item_id)->where('program_id', $program->program_id)->get()->getRow();
                                    
                                    if($prog_cat != '' || $prog_cat != NULL)
                                    {
                                        $model_redemption->program_item_id = $prog_cat->program_item_id;
                                        $model_redemption->unit_point = $prog_cat->unit_point;
                                    }
                                    else
                                        $message .= 'PROGRAM ITEM NOREG;';
                                }
                                else
                                    $message .= 'ITEM SKU NOREG;';
                            }
                            else
                                $message .= 'ITEM SKU EMPTY;';
                        }

                        if($field == 'received_by')
                        {
                           
                            // Menghapus spasi di depan dan belakang
                            $values = trim($values);
                            // Menghapus spasi ganda (mengganti lebih dari satu spasi dengan satu spasi)
                            $values = preg_replace('/\s+/', ' ', $values);
                            // Menghapus karakter spesial (selain huruf, angka, dan spasi)
                            $values = preg_replace('/[^a-zA-Z0-9\s]/', '', $values);
                            // Pastikan tidak ada spasi di akhir setelah karakter spesial dihapus
                            $values = trim($values);
                            $model_redemption->receive_by = $values;
                            
                        }

                        if($field == 'remarks')
                        {
                            // Menghapus spasi di depan dan belakang
                            $values = trim($values);
                            
                            // Menghapus spasi ganda (mengganti lebih dari satu spasi dengan satu spasi)
                            $values = preg_replace('/\s+/', ' ', $values);
                            
                            // Menghapus karakter spesial (selain huruf, angka, dan spasi)
                            $values = preg_replace('/[^a-zA-Z0-9\s]/', '', $values);

                            // Pastikan tidak ada spasi di akhir setelah karakter spesial dihapus
                            $values = trim($values);
                            
                            if($values != "" || $values != NULL)
                            {
                                $model_redemption->remarks = $values;
                            }
                        }

                        if($field == 'quantity')
                        {
                            if($values != "" || $values != NULL)
                            {
                                if(is_numeric($values))
                                    $model_redemption->quantity = $values;
                                else
                                    $message .= 'QUANTITY MUST NUMERIC;';
                            }
                            else
                                $message .= 'QUANTITY EMPTY;';
                        }

                        if($field == 'delivery_order')
                        {
                            if($values != "" || $values != NULL)
                            {
                                $model_redemption->delivery_order = $values;
                            }
                            else
                                $message .= 'DELIVERY ORDER EMPTY;';
                        }
                    }

                    if($message == '')
                    {
                        $model_redemption->code = $value[$r]['redemption_code'];
                        $model_redemption->remarks = $value[$r]['remarks'];
                        $model_redemption->point_redemp = $model_redemption->quantity; //* $point_redeem;
                        
                        if($status_name == 'open')
                        {
                            $saveredemption = [
                                'tracking_number'            => $model_redemption->tracking_number,
                                'status_id'                  => $model_redemption->status_id,
                                'member_id'                  => $model_redemption->member_id,
                                'program_item_id'            => $model_redemption->program_item_id,
                                'unit_point'                 => $model_redemption->unit_point,
                                'quantity'                   => $model_redemption->quantity,
                                'processdate'                => $value[$r]['process_date'],
                                'courier'                    => $value[$r]['delivery_method'],
                                'delivery_order'             => $model_redemption->delivery_order,
                                'delivery_date'              => $value[$r]['delivery_date'],
                                'code'                       => $model_redemption->code,
                                'receive_by'                 => $model_redemption->receive_by,
                                'remarks'                    => $model_redemption->remarks,
                                'unit_point'                 => $value[$r]['unit_point'],
                                'recipient_name'             => $model_redemption->recipient_name,
                                'note1'                      => $value[$r]['note1'],
                                'note2'                      => $value[$r]['note2'],
                                'note3'                      => $value[$r]['note3'],
                                'created_date'               => date("Y-m-d H:i:s"),
                                'modified_date'              => date("Y-m-d H:i:s"),
                                'created_by'                 => $createdby,
                                'modified_by'                => $createdby,
    
                            ];
                            
                            $this->db->table('redemption')->insert($saveredemption);
                            $redemption_id   = $this->db->insertID();

                            if($redemption_id) 
                            {
                                $checkHistory = $this->db->table('redemptionhistory')->select('*')->where('redemption_id', $redemption_id)->get()->getRow();
                                
                                if($checkHistory) 
                                {
                                    // $model_rh = $this->db->table('redemptionhistory')->select('*')->where('redemption_history_id', $checkHistory->redemption_history_id)->get()->getRow();
                                    $model_rh = new redemptionhistoryModel();
                                    
                                    if($status_name == 'open')
										$model_rh->created_date = date("Y-m-d H:i");
                                    if($status_name == 'processing')
                                        $model_rh->created_date = $value[$r]['process_date'];
                                    if($status_name == 'on delivery')
                                        $model_rh->created_date = $value[$r]['on_delivery'];
                                    if($status_name == 'delivered')
                                        $model_rh->created_date = $value[$r]['delivery_date'];
                                    if($status_name == 'retur')
                                        $model_rh->created_date = date('Y-m-d H:i:s');;
                                    if($status_name == 'received')
                                        $model_rh->created_date = $value[$r]['received_date'];
                                        
                                    $model_rh->modified_date = date("Y-m-d H:i");
                                    
                                    $updateredemptionhistory = [
                                        'created_date' => $model_rh->created_date,
                                    ];
                                    
                                    $this->db->table('redemptionhistory')->where('redemption_history_id', $checkHistory->redemption_history_id)->update($updateredemptionhistory);
                                    $redemption_history_id = $this->db->insertID();
                                }
                                else
                                {
                                    $redemption_history = new RedemptionHistoryModel();
                                    $redemption_history->redemption_id = $redemption_id;
                                    $redemption_history->status_id = $model_redemption->status_id;
                                    $redemption_history->note = $value[$r]['note1'];
                                    
                                    if($status_name == 'open')
                                        $redemption_history->created_date = $value[$r]['redemption_date'];
                                    if($status_name == 'processing')
                                        $redemption_history->created_date = $value[$r]['process_date'];
                                    if($status_name == 'on delivery')
                                        $redemption_history->created_date = $value[$r]['on_delivery'];
                                    if($status_name == 'delivered')
                                        $redemption_history->created_date = $value[$r]['delivery_date'];
                                    if($status_name == 'received')
                                        $redemption_history->created_date = $value[$r]['received_date'];
                                    
                                    $redemptionhistory = [
                                        'redemption_id'         => $redemption_history->redemption_id,
                                        'status_id'             => $redemption_history->status_id,
                                        'note'                  => $redemption_history->note,
                                        'created_date'          => $redemption_history->created_date,
                                        'modified_date'         => $redemption_history->created_date,
                                        'created_by'            => $createdby,
                                        'modified_by'           => $createdby,
            
                                    ];
                                    
                                    $this->db->table('redemptionhistory')->insert($redemptionhistory);
                                    $redemption_historyid   = $this->db->insertID();
                                }
                            }

                            if($message == '')
							    $message .= 'Success';
                        }
                        else
                        {
                            $redemption = $this->db->table('redemption')->select('*')->where('tracking_number', $value[$r]['tracking_number'])->get()->getRow();
                            
                            if($redemption != '' || $redemption != NULL)
                            {
                                $model_r = $this->db->table('redemption')->select('*')->where('redemption_id', $redemption->redemption_id)->get()->getRow();
                                $model_r->status_id = $model_redemption->status_id;

                                if($status_name == 'on delivery')
                                    $model_r->recipient = $value[$r]['recipient_name'];
                                
                                if($status_name == 'delivered')
                                {
                                    $model_r->courier = $value[$r]['delivery_method'];
                                    $model_r->delivery_order = $value[$r]['delivery_order'];
                                }
                                
                                if($status_name == 'received')
                                    $model_r->receive_by = $value[$r]['item_received_by'];
                                
                                $saveredemption = [
                                    'recipient_name'        => isset($model_r->recipient) ? $model_r->recipient : $value[$r]['recipient_name'],
                                    'status_id'             => $model_redemption->status_id,
                                    'courier'               => $model_r->courier,
                                    'delivery_order'        => $model_r->delivery_order,
                                    'receive_by'            => $model_r->receive_by,
                                    'created_date'          => date("Y-m-d H:i:s"),
                                    'modified_date'         => date("Y-m-d H:i:s"),
                                    'created_by'            => $createdby,
                                    'modified_by'           => $createdby,
                                ];
                                
                                $this->db->table('redemption')->where('redemption_id', $redemption->redemption_id)->update($saveredemption);
                                
                                if($status_name == 'cancel')
                                {
                                    $member_model = $this->db->table('member')->select('*')->where('member_id', $model_r->member_id)->get()->getRow();
                                    
                                    $member_model->point_balance += $model_r->point_redemp;
                                    $member_model->point_redeem -= $model_r->point_redemp;

                                    $savemember_s = [
                                        'point_balance'              => $member_model->point_balance,
                                        'point_redeem'               => $member_model->point_redeem,
                                    ];

                                    $this->db->table('member')->where('member_id', $member_model->member_id)->update($savemember_s);
                                    $model_member_id = $this->db->insertID();
                                    
                                }
                                else
                                {
                                    $checkHistory = $this->db->table('redemptionhistory')->select('*')->where('redemption_id', $redemption->redemption_id)->where('status_id', $model_r->status_id)->get()->getRow();
                                    
                                    if($checkHistory) 
                                    {
                                        $statusH = $this->db->table('status')->select('*')->where('status_id', $checkHistory->status_id)->get()->getRow();
                                        
                                        $message .= 'STATUS EXIST '.$statusH->name;
                                    }
                                    else
                                    {
                                        $redemption_history = new RedemptionHistoryModel();
                                        $redemption_history->redemption_id = $model_redemption->redemption_id;
                                        $redemption_history->status_id = $model_redemption->status_id;
                                        $redemption_history->note = $value[$r]['note1'];
                                        
                                        if($status_name == 'open')
                                            $redemption_history->created_date = $value[$r]['redemption_date'];
                                        if($status_name == 'processing')
                                            $redemption_history->created_date = $value[$r]['process_date'];
                                        if($status_name == 'on delivery')
                                            $redemption_history->created_date = $value[$r]['on_delivery'];
                                        if($status_name == 'delivered')
                                            $redemption_history->created_date = $value[$r]['delivery_date'];
                                        if($status_name == 'received')
                                            $redemption_history->created_date = $value[$r]['item_received_date'];

                                        $redemptionhistory = [
                                            'redemption_id'         => $redemption->redemption_id,
                                            'status_id'             => $redemption_history->status_id,
                                            'note'                  => $redemption_history->note,
                                            'created_date'          => date("Y-m-d H:i:s"),
                                            'modified_date'         => date("Y-m-d H:i:s"),
                                            'created_by'            => $createdby,
                                            'modified_by'           => $createdby,
                
                                        ];
                                        
                                        $this->db->table('redemptionhistory')->insert($redemptionhistory);
                                        $redemption_historyid   = $this->db->insertID();
                                    }
                                }
                            }
                            else
                            {
							    $message .= 'TRACKING NUMBER NOREG';
                            }
                            
                            if($message == '')
							    $message .= 'Success';
                        }
                    }

                    $returnMessage[] = $message;
                }
                
                $file = 'redemption_Result'.date('Y-m-d');
                $data = $model->importCsv($value, $returnMessage);
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=\"$file".".csv\"");
                header("Pragma: no-cache");
                header("Expires: 0");
                
                $output = fopen('php://output', 'w');
                
                fputcsv($output, array('redemption_confirmation_number', 'tracking_Number', 'user_ID', 'full_name', 'email', 
                'mobile_number', 'company_name', 'contact_phone', 'fax', 'DeliveryAddress1', 
                'DeliveryAddress2', 'city', 'state', 'country', 'postal_code', 
                'recipient_name', 'Item_sku', 'quantity', 'redemption_date', 
                'process_date', 'delivery_date', 'delivery_Order', 'delivery_method', 'received_Date', 
                'received_By', 'redemption_Status', 'remarks', 'unit_point', 'note1', 
                'note2', 'note3', 'result'));
                
                foreach ($data as $data_array) {
                    fputcsv($output, $data_array);
                }
                    fclose($output);
                exit;
            }
            else
            {
                session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                Warning, Program Belum dipilih</div>');
                return redirect()->to('/item/Upload');
            }
        }
        else
        {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Warning, No data in File or No File CSV</div>');
            return redirect()->to('/item/Upload');
        }        
    }

    public function report()
    {
        $program_id = session()->get('program');
		$start_date = date("Y-m-d", strtotime($this->request->getPost('start_date')));
		$finish_date = date("Y-m-d", strtotime($this->request->getPost('finish_date')));

		$tomorrow = mktime(0,0,0,date("m")-2,date("d"),date("Y"));
		$lastmonth = date("Y-m-d", $tomorrow);

		$rules = [
            'start_date' => 'required',
            'finish_date' => 'required',
        ];

		$data = [
			'title' => 'REDEMPTION REPORT',
		];
        
		if($this->validate($rules))
		{
			if($program_id) 
			{
				$query = 'SELECT a.`redemption_id`, pr.name AS program_name, f.created_date AS redemption_date, a.tracking_number, a.code AS redemption_code, 
                        d.code AS member_code, CONCAT(d.first_name, d.last_name) AS full_name, d.personal_email, d.mobile_phone, d.domicile_address, d.company_name, 
                        d.company_phone, d.company_fax, d.company_address, d.domicile_address, e.name AS city, d.state, d.country, d.postal_code, recipient_name AS recipient, 
                        a.courier AS delivery_method, c.code AS item_sku, c.name AS item_name, a.quantity, a.unit_point, a.point_redemp, a.remarks, a.processdate AS process_date, 
                        a.receive_by, h.created_date AS on_delivery_date, a.delivery_date AS delivery_date, delivery_order, j.created_date AS receive_date, receive_by, 
                        z.name AS redemption_status, pod, a.note1, a.note2, a.note3, a.`created_date`, a.`modified_date`, j.created_date AS received_date
                        FROM redemption a 
                        JOIN programitem b ON a.program_item_id = b.program_item_id 
                        JOIN item c ON b.item_id = c.item_id 
                        JOIN member d ON a.member_id = d.member_id 
                        JOIN city e ON d.city_id = e.city_id 
                        JOIN program pr ON b.program_id = pr.program_id 
                        JOIN `status` z ON a.status_id = z.status_id
                        LEFT JOIN (
                            SELECT redemption_id, a.created_date 
                            FROM redemptionhistory a JOIN 
                            `status` b ON a.status_id = b.status_id 
                            WHERE b.code = "RDMP_OPEN"
                        ) f ON a.redemption_id = f.redemption_id 
                        LEFT JOIN (
                            SELECT redemption_id,a.created_date 
                            FROM redemptionhistory a 
                            JOIN `status` b ON a.status_id = b.status_id 
                            WHERE b.code = "RDMP_PROCESSING"
                        ) g ON a.redemption_id = g.redemption_id 
                        LEFT JOIN (
                            SELECT redemption_id,a.created_date 
                            FROM redemptionhistory a 
                            JOIN `status` b ON a.status_id = b.status_id 
                            WHERE b.code = "RDMP_ON_DELIVERY"
                        ) h ON a.redemption_id = h.redemption_id 
                        LEFT JOIN (
                            SELECT redemption_id,a.created_date 
                            FROM redemptionhistory a 
                            JOIN `status` b ON a.status_id = b.status_id 
                            WHERE b.code = "RDMP_DELIVERED"
                        ) i ON a.redemption_id = i.redemption_id 
                        LEFT JOIN (
                            SELECT redemption_id,a.created_date 
                            FROM redemptionhistory a 
                            JOIN `status` b ON a.status_id = b.status_id 
                            WHERE b.code = "RDMP_RECEIVED"
                        ) j ON a.redemption_id = j.redemption_id WHERE b.program_id = "'.$program_id.'" 
                        AND a.created_date >= "'.$start_date.'" 
                        AND a.created_date <= "'.$finish_date.'"
                        ORDER BY f.created_date';

				$sql     = $this->db->query($query);
				$getUO = $sql->getResultArray();
				// echo var_dump($query);exit;
				$date = date("Y-m-d");
				$spreadsheet = new Spreadsheet();

				$sheet = $spreadsheet->getActiveSheet();
				$sheet->setCellValue('A1', 'REDEMPTION CODE');
				$sheet->setCellValue('B1', 'TRACKING NUMBER');
				$sheet->setCellValue('C1', 'USER ID');
				$sheet->setCellValue('D1', 'FULL NAME');
				$sheet->setCellValue('E1', 'EMAIL');
				$sheet->setCellValue('F1', 'MOBILE PHONE');
				$sheet->setCellValue('G1', 'COMPANY NAME');
				$sheet->setCellValue('H1', 'CONTACT PHONE');
				$sheet->setCellValue('I1', 'FAX');
				$sheet->setCellValue('J1', 'DELIVERY ADDRESS1');
				$sheet->setCellValue('K1', 'DELIVERY ADDRESS2');
				$sheet->setCellValue('L1', 'CITY');
				$sheet->setCellValue('M1', 'STATE');
				$sheet->setCellValue('N1', 'COUNTRY');
				$sheet->setCellValue('O1', 'POSTAL CODE');
                $sheet->setCellValue('P1', 'RECIPIENT NAME');
                $sheet->setCellValue('Q1', 'ITEM SKU');
                $sheet->setCellValue('R1', 'QUANTITY');
                $sheet->setCellValue('S1', 'REDEMPTION DATE');
                $sheet->setCellValue('T1', 'PROCESS DATE');
                $sheet->setCellValue('U1', 'DELIVERY DATE');
                $sheet->setCellValue('V1', 'DELIVERY ORDER');
                $sheet->setCellValue('W1', 'DELIVERY METHOD');
                $sheet->setCellValue('X1', 'RECEIVED DATE');
                $sheet->setCellValue('Y1', 'RECEIVED BY');
                $sheet->setCellValue('Z1', 'REDEMPTION STATUS');
                $sheet->setCellValue('AA1', 'POD');
                $sheet->setCellValue('AB1', 'REMARKS');
                $sheet->setCellValue('AC1', 'UNIT POINT');
                $sheet->setCellValue('AD1', 'NOTE1');
                $sheet->setCellValue('AE1', 'NOTE2');
                $sheet->setCellValue('AF1', 'NTOE3');
                $sheet->setCellValue('AG1', 'CREATED DATE');
                $sheet->setCellValue('AH1', 'MODIFIED DATE');
				$rows = 2;
				
				foreach ($getUO as $val) 
				{
					$sheet->setCellValue('A' . $rows, $val['redemption_code']);
                    $sheet->setCellValue('B' . $rows, $val['tracking_number']);
                    $sheet->setCellValue('C' . $rows, $val['member_code']); // user_id
                    $sheet->setCellValue('D' . $rows, $val['full_name']);
                    $sheet->setCellValue('E' . $rows, $val['personal_email']);
                    $sheet->setCellValue('F' . $rows, $val['mobile_phone']);
                    $sheet->setCellValue('G' . $rows, $val['company_name']);
                    $sheet->setCellValue('H' . $rows, $val['company_phone']);
                    $sheet->setCellValue('I' . $rows, $val['company_fax']);
                    $sheet->setCellValue('J' . $rows, $val['domicile_address']);
                    $sheet->setCellValue('K' . $rows, $val['company_address']);
                    $sheet->setCellValue('L' . $rows, $val['city']);
                    $sheet->setCellValue('M' . $rows, $val['state']);
                    $sheet->setCellValue('N' . $rows, $val['country']);
                    $sheet->setCellValue('O' . $rows, $val['postal_code']);
                    $sheet->setCellValue('P' . $rows, $val['recipient']);
                    $sheet->setCellValue('Q' . $rows, $val['item_sku']);
                    $sheet->setCellValue('R' . $rows, $val['quantity']);
                    $sheet->setCellValue('S' . $rows, $val['redemption_date']);
                    $sheet->setCellValue('T' . $rows, $val['process_date']);
                    $sheet->setCellValue('U' . $rows, $val['delivery_date']);
                    $sheet->setCellValue('V' . $rows, $val['delivery_order']);
                    $sheet->setCellValue('W' . $rows, $val['delivery_method']);
                    $sheet->setCellValue('X' . $rows, $val['received_date']);
                    $sheet->setCellValue('Y' . $rows, $val['receive_by']);
                    $sheet->setCellValue('Z' . $rows, $val['redemption_status']);
                    $sheet->setCellValue('AA' . $rows, $val['pod']);
                    $sheet->setCellValue('AB' . $rows, $val['remarks']);
                    $sheet->setCellValue('AC' . $rows, $val['unit_point']);
                    $sheet->setCellValue('AD' . $rows, $val['note1']);
                    $sheet->setCellValue('AE' . $rows, $val['note2']);
                    $sheet->setCellValue('AF' . $rows, $val['note3']);
                    $sheet->setCellValue('AG' . $rows, $val['created_date']);
                    $sheet->setCellValue('AH' . $rows, $val['modified_date']);
					$rows++;
				}
                
				$writer = new Xlsx($spreadsheet);
				header('Content-Type: application/vnd.ms-excel');
				header('Content-Disposition: attachment;filename="'.$date.'_redemption.xlsx"');
				header('Cache-Control: max-age=0');
				ob_end_clean();
				$writer->save('php://output');
				exit();
			}
			else
			{
				session()->setFlashdata('error', 'Program name cannot be empty');
				return redirect()->to('/redemption/report');
			}
		}
		else
		{
			return view('/redemption/report', $data);
		}
    }

}