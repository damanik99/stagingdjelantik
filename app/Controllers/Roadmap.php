<?php 

namespace App\Controllers;
use App\Models\ChannelModel;
use App\Models\CustomModel;
use App\Models\ClientOrganizationModel;
use App\Models\UsersModel;
use App\Models\RoadmapModel;
use App\Models\ImportCsvFormModel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Roadmap extends BaseController
{
	protected $channelModel;

	public function __construct()
    {
		// parent::__construct();
		$session = \Config\Services::session();
		if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }
        
		$this->channelModel = new ChannelModel();
		$this->customModel = new CustomModel();
        $this->usersModel = new usersModel();
        $this->roadmapModel = new RoadmapModel();
		$this->clientOrganizationModel = new ClientOrganizationModel();
	}
	
	public function index()
	{
		$dataroadmap = $this->roadmapModel->index();
		
		$data = [
			'title' => 'Member',
			'dataroadmap' => $dataroadmap
		];
		
		echo view('roadmap/index', $data);
	}

    public function edit($id)
    {
        $rules = [
            'datetime' => 'required',
        ];

		$dataRP = $this->roadmapModel->index($id);
		// echo var_dump($dataRP);exit;
		$data = [
            'title' 	  	=> 'UPDATE ROADMAP',
            'datas'         => $dataRP,
        ];

		if($this->validate($rules))
		{
			$model = new RoadmapModel();
			$model->update($id, [
				'datetime'		=> $this->request->getPost('datetime'),
				'remark'		=> $this->request->getPost('remark'),
				'active'		=> $this->request->getPost('active'),
			]);

			$uc_id = $this->db->affectedRows();
			// echo var_dump($uc_id);exit;
			if($uc_id) 
			{
				session()->setFlashdata('success', 'Data berhasil di Update');
				return redirect()->to('/roadmap');
			}
			session()->setFlashdata('success', 'Data berhasil di Update');
			return redirect()->to('/roadmap');
		}
		else
		{
			return view('/roadmap/edit', $data);
		}
    }

	public function view($id)
	{
		if ($id == NULL) 
        {
            echo view('/supplier/forbidden');
            // echo var_dump("Not Found");exit;
        }
        else
        {
			$views = $this->roadmapModel->index($id);
			
			$data = [
				'title'		=> 'ITEM INFORMATION',
				'view'		=> $views
			];
			echo view('roadmap/view', $data);
		}
		
	}

	public function upload()
	{
		$data = [
			'title' => 'Upload',
		];
		
		echo view('roadmap/upload', $data);
	}

	public function uploadRP()
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
            return redirect()->to('/roadmap/upload');
        }
        
        $value = $model->arrayValue($tempLoc);
        $ext = $file_csv->getClientExtension();
        
        // echo var_dump($value);exit;

        if($ext == 'csv') 
        {
            if($program_id) 
            {
                $fields = array();
                $returnMessage = array();
                for($r=0;$r<count($value);$r++)
                {
                    $roadmap =  new RoadmapModel();
					$program = $this->db->table('program')->select('*')->where('program_id', $program_id)->get()->getRow();
                    
                    $fields[] = array_keys($value[$r]);
                    $message = '';
					
                    $model_r = '';
                    $point_redeem = '';
                    for($p=0;$p<count($fields[$r]);$p++)
                    {
						
						$field = trim($fields[$r][$p]);
                        $values = $value[$r][$field];

						if($field == 'username')
						{ 
							if($values != "")
							{
								$username = $this->db->table('users')->where('username', $values)->get()->getRow();
								
								if($username)
									$roadmap->users_id = $username->users_id;
								else
									$message .= 'USERNAME NOREG;';
							}
							else
								$message .= 'USERNAME EMPTY;';
						}
						
                        if($field == "channel_code")
                        {
                            if($values != "")
                            {
                                $code = $this->db->table('organization')->select('*')->where('code', $values)->get()->getRow();
                                // echo var_dump($code);exit;
                                if($code)
                                {
                                    $clientOrganization = $this->db->table('clientorganization')->select('*')->where('client_id', $program->client_id)->where('organization_id', $code->organization_id)->get()->getRow();
                                    
									if($clientOrganization) 
									{
										$roadmap->client_organization_id = $clientOrganization->client_organization_id;
									}
                                    
                                }
                                else
                                    $message .= 'CHANNEL CODE NOREG;';
                            }
                            else
                                $message .= 'CHANNEL CODE EMPTY;';
                        }

						if($field == "location_name")
						{
							if($values != "")
								$roadmap->location_name = $values;
						}
						
						if($field == "meet_to")
						{
							if($values != "")
								$roadmap->meet_to = $values;
						}
						
						if($field == "subject")
						{
							if($values != "")
								$roadmap->subject = $values;
						}
						
						if($field == "description")
						{
							if($values != "")
								$roadmap->description = $values;
						}
						
						if($field == "date")
						{
							if($values != '')
							{
								if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $values))
								{
									$dt = $value[$r]['date'];
									$roadmap->year = date("Y", strtotime($dt));
									$roadmap->month = date("m", strtotime($dt));
									$roadmap->week = date("W", strtotime($dt));
									$roadmap->day = date("d", strtotime($dt));
								}
								else
									$message .= 'FORMAT DATE INVALID;';
							}
							else
								$message .= 'DATE EMPTY;';
						}
						
						if($field == "time")
						{
							if($values != '')
							{
								if(preg_match("/(2[0-4]|[01][1-9]|10):([0-5][0-9])/", $values))
									$tm = $value[$r]['time'];
								else
									$message .= 'FORMAT TIME INVALID;';
							}
							else
								$message .= 'TIME EMPTY;';
						}

						if($field == "active")
						{
							if($values != '')
							{
								$roadmap->active = $values;
							}
							else
								$message .= 'ACTIVE EMPTY;';
						}
                    }
					
					if($roadmap->client_organization_id == "" && $roadmap->location_name == "")
						$message .= 'CHANNEL CODE OR LOCATION NAME EMPTY;';
					else
					{
						$check = $this->db->table('roadmap')->where('client_organization_id', $roadmap->client_organization_id)
						->where('users_id', $roadmap->users_id)->where('year', $roadmap->year)->where('month', $roadmap->month)
						->where('week', $roadmap->week)->where('day', $roadmap->day)->get()->getRow();

						if($check) 
						{
							if($check->active =='1')
							{
								if($roadmap->active == '0')
								{
									$roadmap->datetime = $dt.' '.$tm;
									$updt_roadmap = $this->db->table('roadmap')->select('*')->where('client_organization_id', $roadmap->client_organization_id)->where('users_id', $roadmap->users_id)->where('datetime', $roadmap->datetime)->get()->getRow();
									
									$id = $updt_roadmap->road_map_id;
									
									$updateAC = new roadmapModel();
									$updateAC->update($id, [
										'users_id'					=> $roadmap->users_id,
										'client_organization_id'	=> $roadmap->client_organization_id,
										'location_name'				=> $roadmap->location_name,
										'subject'					=> $roadmap->subject,
										'meet_to'					=> $roadmap->meet_to,
										'description'				=> $roadmap->description,
										'datetime'					=> $roadmap->datetime,
										'day'						=> $roadmap->day,
										'week'						=> $roadmap->week,
										'month'						=> $roadmap->month,
										'year'						=> $roadmap->year,
										'active'					=> $roadmap->active,
										'program_id'				=> $program->program_id,
										'modified_date'				=> date("Y-m-d H:i:s"),
										'modified_by'       		=> $createdby,
									]);
									
									$roadmap_id   = $this->db->affectedRows();
									if ($roadmap_id) {
										$message .= 'ROADMAP EXIST & ACTIVE SUCCESS';
									}
								}
								else
									$message .= "ROADMAP EXIST;";
							}
							else
							{
								$roadmap->datetime = $dt.' '.$tm;
								
								$updt_roadmap = $this->db->table('roadmap')->select('*')->where('client_organization_id', $roadmap->client_organization_id)
								->where('users_id', $roadmap->users_id)->where('datetime', $roadmap->datetime)->get()->getRow();
								
								$updateAC = new roadmapModel();
								$updateAC->update($updt_roadmap->road_map_id, [
									'users_id'					=> $roadmap->users_id,
									'client_organization_id'	=> $roadmap->client_organization_id,
									'location_name'				=> $roadmap->location_name,
									'subject'					=> $roadmap->subject,
									'meet_to'					=> $roadmap->meet_to,
									'description'				=> $roadmap->description,
									'datetime'					=> $roadmap->datetime,
									'day'						=> $roadmap->day,
									'week'						=> $roadmap->week,
									'month'						=> $roadmap->month,
									'year'						=> $roadmap->year,
									'active'					=> $roadmap->active,
									'program_id'				=> $program->program_id,
									'modified_date'				=> date("Y-m-d H:i:s"),
									'modified_by'       		=> $createdby,
								]);

								$roadmap_id   = $this->db->affectedRows();
								if ($roadmap_id) {
									$message .= 'ROADMAP EXIST & ACTIVE SUCCESS';
								}
								else
								{
									$message .= 'FAILED';
								}
							}
						}
						else
						{
							$check = $this->db->table('roadmap')->where('client_organization_id', $roadmap->client_organization_id)
							->where('users_id', $roadmap->users_id)->where('year', $roadmap->year)->where('month', $roadmap->month)
							->where('week', $roadmap->week)->where('day', $roadmap->day)->get()->getRow();
							if($check)
								$message .= 'ROADMAP EXIST;';
						}
					}
					
                    if($message == '')
                    {
                        $roadmap->active = 1;

						// $roadmap->datetime = $dt.' '.$tm;
						$roadmap->program_id = $program->program_id;

						$saveRP = [ 
							'users_id'					=> $roadmap->users_id,
							'client_organization_id'	=> $roadmap->client_organization_id,
							'location_name'				=> $roadmap->location_name,
							'subject'					=> $roadmap->subject,
							'meet_to'					=> $roadmap->meet_to,
							'description'				=> $roadmap->description,
							'date'						=> $roadmap->date,
							'time'						=> $roadmap->time,
							'active'					=> $roadmap->active,

						];

						$this->db->table('roadmap')->insert($saveRP);
						$roadmapid = $this->db->insertID();
						if ($roadmapid) 
						{
							$message .= 'SUCCESS';
						}
						else
						{
							$message .= 'FAILED';
						}
						
					}
                    
                    $returnMessage[] = $message;
                }

                $file = 'roadmap_Result'.date('Y-m-d');
                $data = $model->importCsv($value, $returnMessage);
                header("Content-type: application/csv");
                header("Content-Disposition: attachment; filename=\"$file".".csv\"");
                header("Pragma: no-cache");
                header("Expires: 0");
        
                $output = fopen('php://output', 'w');
        
                fputcsv($output, array('username', 'channel_code', 'location_name', 'meet_to', 'subject', 'description', 'date', 'time', 'active', 'result'));
        
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
                return redirect()->to('/roadmap/Upload');
            }
        }
        else
        {
            session()->setFlashdata('message', '<div class="alert alert-danger alert-dismissible"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Warning, No data in File or No File CSV</div>');
            return redirect()->to('/roadmap/Upload');
        }        
    }

	public function report()
    {
        $program_id = session()->get('program');

        if($program_id)
		{
			$query = 'SELECT b.username AS username, d.name AS channel_name, location_name AS location_name, 
			subject AS subject, meet_to AS meet_to, a.description AS description, 
			year AS year, month AS month, week AS week, day AS day, datetime AS date_time, 
			CASE WHEN a.active = 1 THEN "YES" ELSE "NO" END AS active, 
			remark AS remark, a.created_date AS created_date 
			FROM roadmap a 
			LEFT JOIN users b ON a.users_id = b.users_id 
			LEFT JOIN clientorganization c ON a.client_organization_id = c.client_organization_id 
			LEFT JOIN organization d ON c.organization_id = d.organization_id 
			WHERE program_id = '.$program_id;

			$sql     = $this->db->query($query);
            $getItem = $sql->getResultArray();
    
            $date = date("Y-m-d");
            $fileName = 'item.xls';
            $spreadsheet = new Spreadsheet();

			$sheet = $spreadsheet->getActiveSheet();
            $sheet->setCellValue('A1', 'USERNAME');
            $sheet->setCellValue('B1', 'CHANNEL NAME');
			$sheet->setCellValue('C1', 'LOCATION NAME');
			$sheet->setCellValue('D1', 'SUBJECT');
			$sheet->setCellValue('E1', 'MEET TO');
			$sheet->setCellValue('F1', 'DESCRIPTION');
			$sheet->setCellValue('G1', 'YEAR');
			$sheet->setCellValue('H1', 'MONTH');
			$sheet->setCellValue('I1', 'WEEK');
			$sheet->setCellValue('J1', 'DAY');
			$sheet->setCellValue('K1', 'DATE TIME');
			$sheet->setCellValue('L1', 'ACTIVE');
			$sheet->setCellValue('M1', 'REMARK');
			$sheet->setCellValue('N1', 'CREATED DATE');
			$rows = 2;

			foreach ($getItem as $val) 
			{
				$sheet->setCellValue('A' . $rows, $val['username']);
                $sheet->setCellValue('B' . $rows, $val['channel_name']);
				$sheet->setCellValue('C' . $rows, $val['location_name']);
				$sheet->setCellValue('D' . $rows, $val['subject']);
				$sheet->setCellValue('E' . $rows, $val['meet_to']);
				$sheet->setCellValue('F' . $rows, $val['description']);
				$sheet->setCellValue('G' . $rows, $val['year']);
				$sheet->setCellValue('H' . $rows, $val['month']);
				$sheet->setCellValue('I' . $rows, $val['week']);
				$sheet->setCellValue('J' . $rows, $val['day']);
				$sheet->setCellValue('K' . $rows, $val['date_time']);
				$sheet->setCellValue('L' . $rows, $val['active']);
				$sheet->setCellValue('M' . $rows, $val['remark']);
				$sheet->setCellValue('N' . $rows, $val['created_date']);
				$rows++;
			}

			$writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$date.'_Roadmap.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit();
		}
		else
        {
            session()->setFlashdata('error', 'Program name cannot be empty');
            return redirect()->to('/roadmap/index');
        }
    }
}