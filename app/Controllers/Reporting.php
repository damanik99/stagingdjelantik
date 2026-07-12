<?php 

namespace App\Controllers;

use App\Models\ReportingModel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use CodeIgniter\I18n\Time;

class Reporting extends BaseController
{
	protected $reportingModel;

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

		$this->reportingModel = new ReportingModel();
	}
	
	public function index()
	{
		$data = [
			'title' => 'Reporting',
		];
		echo view('reporting/index', $data);
		
	}

	public function add()
	{
		// $program_id = session()->get('program');
		// $identity = $this->memberModel->getIdenty();

		// $data = [
		// 	'title'=>'Member Add',
		// 	'identity_type'=>$identity
		// ];

		// echo view('/member/add', $data);
	}
	
	public function attendanceDetailEmail()
	{
		$datestart = $this->request->getPost('datestart');
		$dateend = $this->request->getPost('dateend');
		
		$datareport = $this->reportingModel->getAttendanceSendEmail($datestart, $dateend);
		// echo var_dump($this->request->getPost('datestart'));exit;
		$spreadsheet = new Spreadsheet();
		// tulis header/nama kolom
		$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A1', 'City')
					->setCellValue('B1', 'Username')
					->setCellValue('C1', 'First_name')
					->setCellValue('D1', 'Last_name')
					->setCellValue('E1', 'type')
					->setCellValue('F1', 'Email')
					->setCellValue('G1', 'Title')
					->setCellValue('H1', 'Phone')
					->setCellValue('I1', 'Date')
					->setCellValue('J1', 'Time')
					->setCellValue('K1', 'Location')
					->setCellValue('L1', 'Latitude')
					->setCellValue('M1', 'Longitude')
					->setCellValue('N1', 'Description')
					->setCellValue('O1', 'Subject')
					->setCellValue('P1', 'Notes')
					->setCellValue('Q1', 'ChannelCode')
					->setCellValue('R1', 'ChannelName')
					->setCellValue('S1', 'Address')
					->setCellValue('T1', 'Device');
		
		$column = 2;
		foreach($datareport as $data) 
		{
			$spreadsheet->setActiveSheetIndex(0)
			->setCellValue('A' . $column, $data['City'])
			->setCellValue('B' . $column, $data['username'])
			->setCellValue('C' . $column, $data['First_Name'])
			->setCellValue('D' . $column, $data['Last_Name'])
			->setCellValue('E' . $column, $data['type'])
			->setCellValue('F' . $column, $data['Email'])
			->setCellValue('G' . $column, $data['Title'])
			->setCellValue('H' . $column, $data['Phone'])
			->setCellValue('I' . $column, $data['DATE'])
			->setCellValue('J' . $column, $data['TIME'])
			->setCellValue('K' . $column, $data['Location'])
			->setCellValue('L' . $column, $data['latitude'])
			->setCellValue('M' . $column, $data['longitude'])
			->setCellValue('N' . $column, $data['Description'])
			->setCellValue('O' . $column, $data['SUBJECT'])
			->setCellValue('P' . $column, $data['notes'])
			->setCellValue('Q' . $column, $data['ChannelCode'])
			->setCellValue('R' . $column, $data['ChannelName'])
			->setCellValue('S' . $column, $data['Address'])
			->setCellValue('T' . $column, $data['Device']);
			$column++;
		}

		$writer = new Xlsx($spreadsheet);
		$fileName = 'Report_attandancedetail';

		// Redirect hasil generate xlsx ke web client
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function attendanceDetail()
	{
		$program_id = session()->get('program');
		$datestart  = $this->request->getPost('datestart');
		$dateend    = $this->request->getPost('dateend');

		if (!$program_id) {
			session()->setFlashdata('error', 'Program cannot be empty');
			return redirect()->to('/Reporting');
		}

		if (!$datestart) {
			session()->setFlashdata('error', 'date start cannot be empty');
			return redirect()->to('/Reporting');
		}

		if (!$dateend) {
			session()->setFlashdata('error', 'date end cannot be empty');
			return redirect()->to('/Reporting');
		}

		$datareport = $this->reportingModel->getAttendanceDetail($datestart, $dateend);

		return $this->exportCsv($datareport, 'Report_attandancedetail');
	}

	public function attendanceOnTime()
	{
		$request = service('request');

		if ($request->getMethod() !== 'post') {
			return view('attendance_ontime');
		}

		$downloadType = $request->getPost('download_type');
		$title        = $request->getPost('title');
		$times        = $request->getPost('times');
		$dateStart = date('Y-m-d', strtotime($request->getPost('datestart')));
		$dateEnd   = date('Y-m-d', strtotime($request->getPost('dateend')));		
		$city         = $request->getPost('city');
		$region       = $request->getPost('region');
		$leader        = $request->getPost('leader_name');
		$programId    = session()->get('program');
		// echo var_dump($dateStart);exit;
		if (empty($downloadType) || empty($times) || empty($dateStart) || empty($dateEnd)) {
			return redirect()->back()->with('error', 'Form tidak lengkap');
		}

		$model = new \App\Models\ReportingModel();
		// echo var_dump($model);exit;
		$data = $model->getAttendanceOnTime([
			'program_id'   => $programId,
			'download_type'=> $downloadType,
			'date_start'   => date('Y-m-d', strtotime($dateStart)),
			'date_end'     => date('Y-m-d', strtotime($dateEnd)),
			'times'        => $times,
			'title'        => $title,
			'city'         => $city,
			'region'       => $region
		]);
	
		return $this->exportCsv($data, 'AttendanceOnTime_Report');
	}


	public function attendanceSumary()
	{
		$program_id = session()->get('program');
		$datestart = $this->request->getPost('datestart');
		$dateend = $this->request->getPost('dateend');
		$type = $this->request->getPost('type');
		$attendanceType = $this->reportingModel->attendanceType();

		if($program_id) 
		{
			if($type == "users") 
			{
				$datareport = $this->reportingModel->getAttendanceSumary($type, $datestart, $dateend, $attendanceType);
				// echo var_dump($datareport);exit;
				$spreadsheet = new Spreadsheet();
				//tulis header/nama kolom
				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('A1', 'Date')
							->setCellValue('B1', 'Region')
							->setCellValue('C1', 'City')
							->setCellValue('D1', 'Username')
							->setCellValue('E1', 'Full Name')
							->setCellValue('F1', 'Type')
							->setCellValue('G1', 'Akses System')
							->setCellValue('H1', 'Go Home')
							->setCellValue('I1', 'In Sick')
							->setCellValue('J1', 'Meeting')
							->setCellValue('K1', 'Off Day')
							->setCellValue('L1', 'Personal Leave')
							->setCellValue('M1', 'Training')
							->setCellValue('N1', 'Visit');
				
				$column = 2;
				// echo var_dump($datareport);exit;
				foreach($datareport as $data) 
				{
					$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A' . $column, $data['Date'])
					->setCellValue('B' . $column, $data['region'])
					->setCellValue('C' . $column, $data['city'])
					->setCellValue('D' . $column, $data['username'])
					->setCellValue('E' . $column, $data['Full_Name'])
					->setCellValue('F' . $column, $data['type'])
					->setCellValue('G' . $column, $data['aksessystem'])
					->setCellValue('H' . $column, $data['go_home'])
					->setCellValue('I' . $column, $data['in_sick'])
					->setCellValue('J' . $column, $data['Meeting'])
					->setCellValue('K' . $column, $data['off_day'])
					->setCellValue('L' . $column, $data['personal_leave'])
					->setCellValue('M' . $column, $data['training'])
					->setCellValue('N' . $column, $data['visit']);
					$column++;
				}

				$writer = new Xlsx($spreadsheet);
				$fileName = 'Report_attandancesumary_users';

				// Redirect hasil generate xlsx ke web client
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
			} else if($type == "city") {

				$datareport = $this->reportingModel->getAttendanceSumary($type, $datestart, $dateend, $attendanceType);
				// echo var_dump($datareport);exit;

				$spreadsheet = new Spreadsheet();
				//tulis header/nama kolom
				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('A1', 'Date')
							->setCellValue('B1', 'CITY')
							->setCellValue('C1', 'TOTAL')
							->setCellValue('D1', 'AKSESES SYSTEM')
							->setCellValue('E1', 'NON AKSES')
							->setCellValue('F1', 'GO HOME')
							->setCellValue('G1', 'IN SICK')
							->setCellValue('H1', 'MEETING')
							->setCellValue('I1', 'OFF DAY')
							->setCellValue('J1', 'PERSONAL LEAVE')
							->setCellValue('K1', 'TRAINING')
							->setCellValue('L1', 'VISIT');
				
				$column = 2;
				// echo var_dump($datareport);exit;
				foreach($datareport as $data) 
				{
					$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A' . $column, $data['Date'])
					->setCellValue('B' . $column, $data['city'])
					->setCellValue('C' . $column, $data['total'])
					->setCellValue('D' . $column, $data['AksesSystem'])
					->setCellValue('E' . $column, $data['AksesSystem'])
					->setCellValue('F' . $column, $data['go_home'])
					->setCellValue('G' . $column, $data['in_sick'])
					->setCellValue('H' . $column, $data['Meeting'])
					->setCellValue('I' . $column, $data['off_day'])
					->setCellValue('J' . $column, $data['personal_leave'])
					->setCellValue('K' . $column, $data['training'])
					->setCellValue('L' . $column, $data['visit']);
					$column++;
				}

				$writer = new Xlsx($spreadsheet);
				$fileName = 'Report_attandancesumary_city';

				// Redirect hasil generate xlsx ke web client
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
			} else if ($type == "region") {

				$datareport = $this->reportingModel->getAttendanceSumary($type, $datestart, $dateend, $attendanceType);
				// echo var_dump($datareport);exit;

				$spreadsheet = new Spreadsheet();
				//tulis header/nama kolom
				$spreadsheet->setActiveSheetIndex(0)
							->setCellValue('A1', 'Date')
							->setCellValue('B1', 'REGION')
							->setCellValue('C1', 'TOTAL')
							->setCellValue('D1', 'AKSES SYSTEM')
							->setCellValue('E1', 'NON AKSES')
							->setCellValue('F1', 'GO HOME')
							->setCellValue('G1', 'IN SICK')
							->setCellValue('H1', 'MEETING')
							->setCellValue('I1', 'OFF DAY')
							->setCellValue('J1', 'PERSONAL LEAVE')
							->setCellValue('K1', 'TRAINING')
							->setCellValue('L1', 'VISIT');
				
				$column = 2;
				// echo var_dump($datareport);exit;
				foreach($datareport as $data) 
				{
					$spreadsheet->setActiveSheetIndex(0)
					->setCellValue('A' . $column, $data['Date'])
					->setCellValue('B' . $column, $data['region'])
					->setCellValue('C' . $column, $data['total'])
					->setCellValue('D' . $column, $data['AksesSystem'])
					->setCellValue('E' . $column, $data['AksesSystem'])
					->setCellValue('F' . $column, $data['go_home'])
					->setCellValue('G' . $column, $data['in_sick'])
					->setCellValue('H' . $column, $data['Meeting'])
					->setCellValue('I' . $column, $data['off_day'])
					->setCellValue('J' . $column, $data['personal_leave'])
					->setCellValue('K' . $column, $data['training'])
					->setCellValue('L' . $column, $data['visit']);
					$column++;
				}

				$writer = new Xlsx($spreadsheet);
				$fileName = 'Report_attandancesumary_region';

				// Redirect hasil generate xlsx ke web client
				header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
				header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
				header('Cache-Control: max-age=0');

				$writer->save('php://output');
			} 
			else {
				session()->setFlashdata('error', 'Download Type cannot be empty');
				return redirect()->to('/Reporting');
			}
		} else {
			session()->setFlashdata('error', 'Program cannot be empty');
			return redirect()->to('/Reporting');
		}
		
	}

	public function attendanceConsistency()
	{
		$datestart = $this->request->getPost('datestart');
		$dateend = $this->request->getPost('dateend');
		$type = $this->request->getPost('type');
		$title = $this->request->getPost('title');
		// $start = new Time($datestart);
        // echo var_dump($start);exit;
		$attendanceType = $this->reportingModel->attendanceType();
		// echo var_dump($type);exit;
		if($type == "users")
		{
			$datareport = $this->reportingModel->getAttendanceConsistency($datestart, $dateend, $type, $title);
			// echo var_dump($datareport);exit;
			$spreadsheet = new Spreadsheet();
			//tulis header/nama kolom
			$spreadsheet->setActiveSheetIndex(0)
						->setCellValue('A1', 'city')
						->setCellValue('B1', 'username')
						->setCellValue('C1', 'Full_Name')
						->setCellValue('D1', 'type')
						->setCellValue('E1', 'AksesSystem');
			
			$column = 2;
			// echo var_dump($datareport);exit;
			foreach($datareport as $data) 
			{
				$spreadsheet->setActiveSheetIndex(0)
				->setCellValue('A' . $column, $data['Region'])
				->setCellValue('B' . $column, $data['City'])
				->setCellValue('C' . $column, $data['Full_Name'])
				->setCellValue('D' . $column, $data['leader_name'])
				->setCellValue('E' . $column, $data['AksesSystem']);
				$column++;
			}

			$writer = new Xlsx($spreadsheet);
			$fileName = 'Report_attandance_consistency';

			// Redirect hasil generate xlsx ke web client
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename='.$fileName.'.xlsx');
			header('Cache-Control: max-age=0');

			$writer->save('php://output');
		}
	}

	public function edit($id)
	{
		
	}

}