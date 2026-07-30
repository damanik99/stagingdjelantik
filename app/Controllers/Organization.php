<?php

namespace App\Controllers;

use App\Models\OrganizationModel;
use App\Models\OrganizationTypeModel;
use App\Models\CompanyProgramModel;
use App\Models\StatusModel;
use App\Models\DatalistModel;
use App\Models\ProvinceModel;

class Organization extends BaseController
{
    protected OrganizationModel $organization;
    protected OrganizationTypeModel $OrganizationType;
    protected CompanyProgramModel $companyProgram;
    protected StatusModel $status;
    protected DatalistModel $datalistModel;

    protected ProvinceModel $provinceModel;

    public function __construct()
    {
        $session = \Config\Services::session();

        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->organization = new OrganizationModel();
        $this->OrganizationType = new OrganizationTypeModel();
        $this->companyProgram = new CompanyProgramModel();
        $this->status = new StatusModel();
        $this->datalistModel = new DatalistModel();

        $this->provinceModel  = new ProvinceModel();
    }

    public function index()
    {
        $data['organizationType'] = $this->OrganizationType->findAll();

        return view('organization/index', $data);
    }

    public function buyerindex()
    {
        $data['organizationType'] = $this->OrganizationType->findAll();

        return view('organization/buyer', $data);
    }

    public function pkkindex()
    {
        $data['organizationType'] = $this->OrganizationType->findAll();

        return view('organization/pkk', $data);
    }

    public function create()
    {
        $code = $this->datalistModel->setCounterNumber('organization', 'organization_code', 'ORGZ');
        $organizationtype = $result = $this->db->table('organization_type a')->get()->getResultArray();
        $provinces = $this->provinceModel->orderBy('provinsi', 'ASC')->findAll();

        $data = [
            'code' => $code,
            'organizationtype' => $organizationtype,
            'provinces' => $provinces
        ];

        return view('organization/create', $data);
    }

    public function savecreate()
    {
        $validation = \Config\Services::validation();

        $rules = [
            'code'                  => 'required',
            'organization_type_id'  => 'required',
            'organization_name'     => 'required',
            'pic_name'              => 'required',
            'phone'                 => 'required',
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => $validation->getErrors()
            ]);
        }

        $program_id = session()->get('program');
        $user_id    = session()->get('users_id');

        $address = trim($this->request->getPost('address'));
        $village = trim($this->request->getPost('village_name'));
        $district = trim($this->request->getPost('district_name'));
        $city = trim($this->request->getPost('city_name'));
        $province = trim($this->request->getPost('provinsi_name'));

        $fullAddress = implode(', ', array_filter([
            $address,
            $village,
            $district,
            $city,
            $province
        ]));
        
        $this->db->transBegin();

        try {

            $organization = [
                'organization_code' => $this->request->getPost('code'),
                'organization_name' => $this->request->getPost('organization_name'),
                'pic_name'          => $this->request->getPost('pic_name'),
                'address'           => $fullAddress,
                'phone'             => $this->request->getPost('phone'),
                'email'             => $this->request->getPost('email'),
                'created_by'        => $user_id,
            ];

            $this->db->table('organization')->insert($organization);

            $organization_id = $this->db->insertID();

            $organizationProgram = [
                'organization_id'      => $organization_id,
                'program_id'           => $program_id,
                'organization_type_id' => $this->request->getPost('organization_type_id'),
                'status_id'            => 25,
                'created_date'         => date('Y-m-d H:i:s'),
                'created_by'           => $user_id,
            ];
            
            $this->db->table('organization_program')->insert($organizationProgram);

            if ($this->db->transStatus() === false) 
            {
                $this->db->transRollback();

                $error = $this->db->error();

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Gagal menyimpan data.',
                    'code'    => $error['code'],
                ]);
            }

            $this->db->transCommit();

            $type = $this->request->getPost('organization_type_id');

            switch ($type) {

                case '1':
                    $redirect = base_url('Organization');
                    break;

                case '2':
                    $redirect = base_url('Organization/buyerindex');
                    break;

                case '3':
                    $redirect = base_url('Organization/pkkindex');
                    break;

                default:
                    $redirect = base_url('Organization');
                    break;
            }

            return $this->response->setJSON([
                'status'   => true,
                'message'  => 'Data berhasil disimpan',
                'redirect' => $redirect
            ]);

        } catch (\Throwable $e) {

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function suppliertables()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $program_id = session()->get('program');

        $baseQuery = "
            FROM organization_program op
            JOIN organization o
                ON op.organization_id = o.organization_id
            JOIN program p
                ON op.program_id = p.program_id
            JOIN organization_type ot
                ON op.organization_type_id = ot.organization_type_id
            JOIN status s
                ON op.status_id = s.status_id
            WHERE
                ot.type_code = 'SUPPLIER'
                AND p.program_id = ?
        ";

        $params = [$program_id];

        $filter = "";

        if (!empty($search)) {

            $filter .= "
                AND (
                    o.organization_code LIKE ?
                    OR o.organization_name LIKE ?
                    OR ot.type_name LIKE ?
                    OR o.pic_name LIKE ?
                    OR o.state LIKE ?
                    OR o.phone LIKE ?
                    OR o.email LIKE ?
                    OR s.status_name LIKE ?
                )
            ";

            $keyword = "%{$search}%";

            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        $totalRecords = $this->db
            ->query("SELECT COUNT(*) cnt {$baseQuery}", [$program_id])
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
            'o.organization_code',
            'o.organization_name',
            'o.pic_name',
            'o.state',
            'o.phone',
            'o.email',
            's.status_name',
            'o.created_date'
        ];

        $orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy = $orderColumn[
            $request->getPost('order')[0]['column'] ?? 7
        ];

        $sql = "
            SELECT
                op.organization_program_id,
                o.*,
                ot.type_name,
                s.status_code,
                s.status_name
            {$baseQuery}
            {$filter}
            ORDER BY {$orderBy} {$orderDirection}
            LIMIT ?, ?
        ";

        $queryParams = $params;
        $queryParams[] = (int)$start;
        $queryParams[] = (int)$length;

        $query = $this->db->query($sql, $queryParams);

        $data = [];

        foreach ($query->getResultArray() as $row) {

            if ($row['status_code'] == 'ACTV') {

                $row['status_badge'] =
                    '<span class="badge badge-success">'
                    .$row['status_name'].
                    '</span>';

            } else {

                $row['status_badge'] =
                    '<span class="badge badge-danger">'
                    .$row['status_name'].
                    '</span>';

            }

            $row['action'] = '
                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail"
                    data-id="'.$row['organization_program_id'].'"
                    title="Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="'.base_url('Organization/edit/'.$row['organization_program_id']).'"
                    class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1">
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

    public function buyertables()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $program_id = session()->get('program');

        $baseQuery = "
            FROM organization_program op
            JOIN organization o
                ON op.organization_id = o.organization_id
            JOIN program p
                ON op.program_id = p.program_id
            JOIN organization_type ot
                ON op.organization_type_id = ot.organization_type_id
            JOIN status s
                ON op.status_id = s.status_id
            WHERE
                ot.type_code = 'BUYER'
                AND p.program_id = ?
        ";

        $params = [$program_id];

        $filter = "";

        if (!empty($search)) {

            $filter .= "
                AND (
                    o.organization_code LIKE ?
                    OR o.organization_name LIKE ?
                    OR ot.type_name LIKE ?
                    OR o.pic_name LIKE ?
                    OR o.state LIKE ?
                    OR o.phone LIKE ?
                    OR o.email LIKE ?
                    OR s.status_name LIKE ?
                )
            ";

            $keyword = "%{$search}%";

            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        $totalRecords = $this->db
            ->query("SELECT COUNT(*) cnt {$baseQuery}", [$program_id])
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
            'o.organization_code',
            'o.organization_name',
            'o.pic_name',
            'o.state',
            'o.phone',
            'o.email',
            's.status_name',
            'o.created_date'
        ];

        $orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy = $orderColumn[
            $request->getPost('order')[0]['column'] ?? 7
        ];

        $sql = "
            SELECT
                op.organization_program_id,
                o.*,
                ot.type_name,
                s.status_code,
                s.status_name
            {$baseQuery}
            {$filter}
            ORDER BY {$orderBy} {$orderDirection}
            LIMIT ?, ?
        ";

        $queryParams = $params;
        $queryParams[] = (int)$start;
        $queryParams[] = (int)$length;

        $query = $this->db->query($sql, $queryParams);

        $data = [];

        foreach ($query->getResultArray() as $row) {

            if ($row['status_code'] == 'ACTV') {

                $row['status_badge'] =
                    '<span class="badge badge-success">'
                    .$row['status_name'].
                    '</span>';

            } else {

                $row['status_badge'] =
                    '<span class="badge badge-danger">'
                    .$row['status_name'].
                    '</span>';

            }

            $row['action'] = '
                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail"
                    data-id="'.$row['organization_program_id'].'"
                    title="Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="'.base_url('Organization/edit/'.$row['organization_program_id']).'"
                    class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1">
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

    public function pkktables()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $program_id = session()->get('program');

        $baseQuery = "
            FROM organization_program op
            JOIN organization o
                ON op.organization_id = o.organization_id
            JOIN program p
                ON op.program_id = p.program_id
            JOIN organization_type ot
                ON op.organization_type_id = ot.organization_type_id
            JOIN status s
                ON op.status_id = s.status_id
            WHERE
                ot.type_code = 'PKK'
                AND p.program_id = ?
        ";

        $params = [$program_id];

        $filter = "";

        if (!empty($search)) {

            $filter .= "
                AND (
                    o.organization_code LIKE ?
                    OR o.organization_name LIKE ?
                    OR ot.type_name LIKE ?
                    OR o.pic_name LIKE ?
                    OR o.state LIKE ?
                    OR o.phone LIKE ?
                    OR o.email LIKE ?
                    OR s.status_name LIKE ?
                )
            ";

            $keyword = "%{$search}%";

            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
            $params[] = $keyword;
        }

        $totalRecords = $this->db
            ->query("SELECT COUNT(*) cnt {$baseQuery}", [$program_id])
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
            'o.organization_code',
            'o.organization_name',
            'o.pic_name',
            'o.state',
            'o.phone',
            'o.email',
            's.status_name',
            'o.created_date'
        ];

        $orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy = $orderColumn[
            $request->getPost('order')[0]['column'] ?? 7
        ];

        $sql = "
            SELECT
                op.organization_program_id,
                o.*,
                ot.type_name,
                s.status_code,
                s.status_name
            {$baseQuery}
            {$filter}
            ORDER BY {$orderBy} {$orderDirection}
            LIMIT ?, ?
        ";

        $queryParams = $params;
        $queryParams[] = (int)$start;
        $queryParams[] = (int)$length;

        $query = $this->db->query($sql, $queryParams);

        $data = [];

        foreach ($query->getResultArray() as $row) {

            if ($row['status_code'] == 'ACTV') {

                $row['status_badge'] =
                    '<span class="badge badge-success">'
                    .$row['status_name'].
                    '</span>';

            } else {

                $row['status_badge'] =
                    '<span class="badge badge-danger">'
                    .$row['status_name'].
                    '</span>';

            }

            $row['action'] = '
                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail"
                    data-id="'.$row['organization_program_id'].'"
                    title="Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="'.base_url('Organization/edit/'.$row['organization_program_id']).'"
                    class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1">
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
    
    public function detail($id)
    {
        $data = $this->organization->getOrganizationPro($id);
        // $data = $this->db->table('organization')->where('organization_id', $id)->get()->getResultArray();
        // var_dump($data);exit;
        $data = [
            'views' => $data,
        ];

        return view('organization/detail', $data);
    }

    public function edit($id)
    {
        $organizationtype = $this->db->table('organization_type a')->get()->getResultArray();
        $dataOrgz = $this->organization->getOrganizationPro($id);
        $status = $this->db->table('status')->where('module', 'ORGANIZATION')->get()->getResultArray();

        $data = [
            'organizationtype' => $organizationtype,
            'dataOrgz' => $dataOrgz,
            'status' => $status
        ];

        return view('organization/edit', $data);
    }

    public function saveedit($organization_program_id)
    {
        // var_dump($this->request->getPost('organization_type_id'));exit;
        $rules = [
            'code'               => 'required',
            'organization_name'  => 'required',
            'pic_name'           => 'required',
            'phone'              => 'required',
        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([
                'status'  => false,
                'errors'  => $this->validator->getErrors()
            ]);
        }

        $user_id = session()->get('users_id');

        $this->db->transBegin();

        try {

            // Ambil organization_id dari organization_program
            $organizationProgram = $this->db
                ->table('organization_program')
                ->where('organization_program_id', $organization_program_id)
                ->get()
                ->getRowArray();

            if (!$organizationProgram) {

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Data tidak ditemukan.'
                ]);

            }

            $organization_id = $organizationProgram['organization_id'];

            // Gabungkan alamat
            $address = trim($this->request->getPost('address'));

            if ($this->request->getPost('village_name')) {
                $address .= ', '.$this->request->getPost('village_name');
            }

            if ($this->request->getPost('district_name')) {
                $address .= ', '.$this->request->getPost('district_name');
            }

            if ($this->request->getPost('city_name')) {
                $address .= ', '.$this->request->getPost('city_name');
            }

            if ($this->request->getPost('province_name')) {
                $address .= ', '.$this->request->getPost('province_name');
            }

            $organization = [
                'organization_code' => $this->request->getPost('code'),
                'organization_name' => $this->request->getPost('organization_name'),
                'pic_name'          => $this->request->getPost('pic_name'),
                'address'           => $address,
                'phone'             => $this->request->getPost('phone'),
                'email'             => $this->request->getPost('email'),
                'note'              => $this->request->getPost('note'),
                'modified_date'     => date('Y-m-d H:i:s'),
                'modified_by'       => $user_id
            ];

            $this->db
                ->table('organization')
                ->where('organization_id', $organization_id)
                ->update($organization);

            // Update organization type jika berubah
            $organizationProgram = [
                'status_id'       => $this->request->getPost('status_id'),
                'modified_date'   => date('Y-m-d H:i:s'),
                'modified_by'     => $user_id
            ];

            $this->db
                ->table('organization_program')
                ->where('organization_program_id', $organization_program_id)
                ->update($organizationProgram);

            if ($this->db->transStatus() === false) {

                $this->db->transRollback();

                return $this->response->setJSON([
                    'status'  => false,
                    'message' => 'Gagal mengubah data.'
                ]);
            }

            $this->db->transCommit();

            $type = $this->request->getPost('organization_type_id');

            switch ($type) {

                case 'Supplier':
                    $redirect = base_url('Organization');
                    break;

                case 'Buyer':
                    $redirect = base_url('Organization/buyerindex');
                    break;

                case 'Pkk':
                    $redirect = base_url('Organization/pkkindex');
                    break;

                default:
                    $redirect = base_url('Organization');
                    break;
            }

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Data berhasil diubah',
                'redirect' => $redirect
            ]);

        } catch (\Throwable $e) {

            $this->db->transRollback();

            return $this->response->setJSON([
                'status'  => false,
                'message' => $e->getMessage()
            ]);
        }
    }

}