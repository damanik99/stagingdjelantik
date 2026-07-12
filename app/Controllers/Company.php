<?php

namespace App\Controllers;

use App\Models\CompanyModel;
use App\Models\CompanyTypeModel;
use App\Models\CompanyProgramModel;
use App\Models\StatusModel;

class Company extends BaseController
{
    protected CompanyModel $company;
    protected CompanyTypeModel $companyType;
    protected CompanyProgramModel $companyProgram;
    protected StatusModel $status;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->company = new CompanyModel();
        $this->companyType = new CompanyTypeModel();
        $this->companyProgram = new CompanyProgramModel();
        $this->status = new StatusModel();
    }

    public function index()
    {
        $data['title'] = 'Company';
        $data['companytypes'] = $this->companyType->findAll();

        return view('company/index', $data);
    }

    public function create()
    {
        $companyType = $this->companyType
                ->where('status', 'active')
                ->findAll();
        $status = $this->status->getByModule('COMPANY');

        $data = [
            'title' => 'Create Company',
            'companyTypes' => $companyType,
            'status' => $status
        ];

        return view('company/create', $data);
    }

    public function store()
    {
        $program_id = session()->get('program');
        $rules = [
            'company_type_id' => 'required',
            'company_name' => 'required',
            'email' => 'permit_empty|valid_email',
            'latitude' => 'permit_empty|decimal',
            'longitude' => 'permit_empty|decimal'
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $companyName = trim($this->request->getPost('company_name'));

        $cekCp = $this->company
            ->where('company_name', $companyName)
            ->first();

        if ($cekCp) {
           return $this->response->setJSON([
                'status' => false,
                'message' => 'Company Name sudah terdaftar.'
            ]);
        }


        $this->db->transStart();
        $this->company->insert([
            'company_name' => $this->request->getPost('company_name'),
            'pic_name'     => $this->request->getPost('pic_name'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email'),
            'address'      => $this->request->getPost('address'),
            'latitude'     => $this->request->getPost('latitude'),
            'longitude'    => $this->request->getPost('longitude'),
            'status_id'    => $this->request->getPost('status_id'),
            'created_by'   => session()->get('user_id')
        ]);

        $companyId = $this->company->getInsertID();

        $this->companyProgram->insert([
            'company_id'      => $companyId,
            'program_id'      => $program_id,
            'company_type_id' => $this->request->getPost('company_type_id'),
            'status_id'       => $this->request->getPost('status_id'),
            'created_by'      => session()->get('user_id')
        ]);

        $this->db->transComplete();

        if (!$this->db->transStatus()) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Gagal menyimpan data'
            ]);
        }

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Company berhasil disimpan'
        ]);
    }

    public function datatables()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $baseQuery = "
            FROM company_program a
            JOIN company b
                ON a.company_id = b.company_id
            JOIN companytype c
                ON a.company_type_id = c.type_id
            JOIN status d
                ON a.status_id = d.status_id
            WHERE 1=1
        ";

        $filter = "";
        $params = [];

        if (!empty($search)) {

            $filter .= "
                AND (
                    b.company_name LIKE ?
                    OR c.type_name LIKE ?
                    OR b.pic_name LIKE ?
                    OR b.phone LIKE ?
                    OR b.email LIKE ?
                    OR d.status_name LIKE ?
                )
            ";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $totalRecords = $this->db
            ->query("SELECT COUNT(*) cnt {$baseQuery}")
            ->getRow()
            ->cnt;

        $totalFiltered = $totalRecords;

        if (!empty($search)) {

            $totalFiltered = $this->db
                ->query(
                    "SELECT COUNT(*) cnt {$baseQuery} {$filter}",
                    $params
                )
                ->getRow()
                ->cnt;
        }

        $orderColumn = [
            'b.company_name',
            'c.type_name',
            'b.pic_name',
            'b.phone',
            'b.email',
            'd.status_name',
            'b.created_date'
        ];

        $orderDirection =
            $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy =
            $orderColumn[
                $request->getPost('order')[0]['column'] ?? 6
            ];

        $sql = "
            SELECT
                b.*,
                a.company_program_id,
                c.type_name AS company_type,
                d.status_code,
                d.status_name
            {$baseQuery}
            {$filter}
            ORDER BY {$orderBy} {$orderDirection}
            LIMIT ?, ?
        ";

        $params[] = (int)$start;
        $params[] = (int)$length;

        $query = $this->db->query($sql, $params);

        $data = [];

        foreach ($query->getResultArray() as $row) {

            if ($row['status_code'] == 'ACTV') {

                $row['status_badge'] =
                    '<span class="badge badge-success">'
                    .$row['status_name'].
                    '</span>';

            } elseif ($row['status_code'] == 'INAC') {

                $row['status_badge'] =
                    '<span class="badge badge-danger">'
                    .$row['status_name'].
                    '</span>';

            } else {

                $row['status_badge'] =
                    '<span class="badge badge-secondary">'
                    .$row['status_name'].
                    '</span>';
            }

            $row['action'] = '
                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail" data-original-title="View" data-id="'.$row['company_program_id'].'"
                    title="Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="'.base_url().'/Company/edit/'.$row['company_program_id'].'"
                class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1"  data-toggle="tooltip">
                    <i class="fa fa-pencil"></i>
                </a>
            ';

            $data[] = $row;
        }

        return $this->response->setJSON([
            "draw" => intval($draw),
            "recordsTotal" => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data" => $data
        ]);
    }

    public function edit($id = null)
    {
        $companyModel        = new CompanyModel();
        $companyProgramModel = new CompanyProgramModel();

        $program_id = session()->get('program');
        
        /**
         * ======================================
         * GET
         * ======================================
         */
        if ($this->request->getMethod() === 'get') {

            $db = db_connect();
            $status = $this->db->table('status')->where('module', 'COMPANY')->get()->getResultArray();

            $companyprograms = $this->db->table('company_program a')
                ->select('a.*, company.company_id, company.company_name, companytype.type_id, a.program_id, 
                company.phone, company.email, company.address, company.latitude, company.longitude, company.pic_name ')
                ->join('company', 'a.company_id = company.company_id')
                ->join('companytype', 'a.company_type_id = companytype.type_id')
                ->where('a.company_program_id', $id)
                ->where('a.program_id', $program_id ?? [])
                ->get()->getRowArray();

            $data = [
                'company'             => $companyprograms,
                'companyTypes'        => $db->table('companytype')->get()->getResultArray(),
                'companyprograms'     => $companyprograms,
                'statuses'            => $status,
            ];

            return view('company/edit', $data);
        }

        /**
         * ======================================
         * POST
         * ======================================
         */

        $rules = [
            'company_name' => [
                'label' => 'Company Name',
                'rules' => 'required|max_length[200]'
            ],
            'pic_name' => [
                'label' => 'PIC Name',
                'rules' => 'required|max_length[100]'
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'permit_empty|max_length[30]'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'permit_empty|valid_email'
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'permit_empty'
            ]
        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Validation failed.',
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $db = db_connect();
        $db->transBegin();

        try {

            /**
             * ======================================
             * UPDATE COMPANY
             * ======================================
             */

            $companyprograms = $this->db->table('company_program a')
                ->select('company.company_id, a.company_program_id ')
                ->join('company', 'a.company_id = company.company_id')
                ->where('a.company_program_id', $id)
                ->where('a.program_id', $program_id ?? [])
                ->get()->getRowArray();

            $company = $companyModel->find($companyprograms['company_id']);
            
            if (!$company) {
                throw new \Exception('Company not found.');
            }
            
            $fields = [
                'company_name',
                'pic_name',
                'phone',
                'email',
                'address',
                'latitude',
                'longitude',
            ];

            $updateData = [];
            foreach ($fields as $field) {

                $newValue = $this->request->getPost($field);
                
                if ((string)$company[$field] !== (string)$newValue) {
                    $updateData[$field] = $newValue;
                }
            }

            if (!empty($updateData)) {

                $updateData['modified_by'] = session()->get('user_id');

                $companyModel->update($companyprograms['company_id'], $updateData);
            }
            
            /**
             * ======================================
             * UPDATE COMPANY PROGRAM 
             * ======================================
             */
            $companyProgramModel->update($id, [
                'program_id'      => $program_id,
                'company_type_id' => $this->request->getPost('company_type_id'),
                'status_id'       => $this->request->getPost('status_id'),
                'modified_by'      => session()->get('user_id')
            ]);

            if ($db->transStatus() === false) {

                $db->transRollback();

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Failed to update company.'
                ]);
            }

            $db->transCommit();

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Company successfully updated.'
            ]);

        } catch (\Throwable $e) {

            $db->transRollback();

            throw $e;
        }
    }

    public function detail($id)
    {
        $detail = $this->company->detail($id);
        $data = [
            'title' => 'View Company',
            'detail' => $detail
        ];

        return view('company/detail', $data);
    }

}