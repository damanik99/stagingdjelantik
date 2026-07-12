<?php

namespace App\Controllers;

use App\Models\CompanyTypeModel;

class CompanyType extends BaseController
{
    protected CompanyTypeModel $companyType;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }
        $this->companyType = new CompanyTypeModel();
    }

    public function index()
    {
        $data['title'] = 'Company Type';
        $data['companytypes'] = $this->companyType->findAll();

        return view('companytype/index', $data);
    }

    public function create()
    {
        return view('CompanyType/create', [
            'title' => 'Create Company Type'
        ]);
    }

    public function store()
    {
        $validation = \Config\Services::validation();

        $users_id = session()->get('users_id');
        $typName = ucfirst($this->request->getPost('type_name'));

        $rules = [
            'type_name' => [
                'rules' => 'required|is_unique[companytype.type_name]',
                'errors' => [
                    'required' => 'Type Name wajib diisi',
                    'is_unique' => 'Type Name sudah digunakan'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $validation->getErrors()
            ]);
        }

        $this->companyType->insert([
            'type_name' => $typName,
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'created_by' => $users_id
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data saved successfully'
        ]);
    }

    public function edit($id)
    {
        $row = $this->companyType->find($id);

        $data = [
            'title' => 'Edit Company Type',
            'row' => $row,
        ];

        return view('companytype/edit', $data);
    }

    public function update($id)
    {
        $row = $this->companyType->find($id);

        $rules = [
            'type_name' => [
                'rules' => 'required'
            ]
        ];

        if (
            strtolower($row['type_name']) != strtolower($this->request->getPost('type_name'))
        ) {
            $rules['type_name']['rules'] .= '|is_unique[companytype.type_name]';
        }

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->companyType->update($id, [
            'type_name' => $this->request->getPost('type_name'),
            'description' => $this->request->getPost('description'),
            'status' => $this->request->getPost('status'),
            'modified_by' => session()->get('user_id')
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil diupdate'
        ]);
    }

    public function delete($id)
    {
        $this->companyType->delete($id);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Data berhasil dihapus'
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
            FROM companytype a
            WHERE 1=1
        ";

        $filter = "";
        $params = [];

        if (!empty($search)) {

            $filter .= "
                AND (
                    a.type_name LIKE ?
                    OR a.description LIKE ?
                    OR a.status LIKE ?
                )
            ";

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
            'a.type_name',
            'a.description',
            'a.status',
            'a.created_date'
        ];

        $orderDirection =
            $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy =
            $orderColumn[
                $request->getPost('order')[0]['column'] ?? 3
            ];

        $sql = "
            SELECT
                a.*
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

            $row['action'] = '
                <a href="'.base_url().'/companytype/edit/'.$row['type_id'].'"
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

}