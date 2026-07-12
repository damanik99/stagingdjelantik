<?php

namespace App\Controllers;

use App\Models\WarehouseModel;

class Warehouse extends BaseController
{
    protected WarehouseModel $warehouse;

    public function __construct()
    {
         $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->warehouse = new WarehouseModel();
    }

    private function generateWarehouseCode()
    {
        $prefix = 'WH';
        $date = date('Ymd');

        $last = $this->warehouse
            ->like('warehouse_code', $prefix.'-'.$date, 'after')
            ->orderBy('warehouse_id', 'DESC')
            ->first();

        if ($last) {

            $lastNumber = substr(
                $last['warehouse_code'],
                -4
            );

            $seq = intval($lastNumber) + 1;

        } else {

            $seq = 1;
        }

        return $prefix.'-'.$date.'-'.str_pad(
            $seq,
            4,
            '0',
            STR_PAD_LEFT
        );
    }

    public function index()
    {
        $data['title'] = 'Warehose';

        return view('warehouse/index', $data);
    }

    public function datatables()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $baseQuery = "
            FROM warehouse a
            WHERE a.is_deleted = 0
        ";

        $filter = "";
        $params = [];

        if (!empty($search)) {

            $filter .= "
                AND (
                    a.warehouse_code LIKE ?
                    OR a.warehouse_name LIKE ?
                    OR a.address LIKE ?
                )
            ";

            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
            $params[] = "%{$search}%";
        }

        $totalRecords = $this->db
            ->query(
                "SELECT COUNT(*) cnt {$baseQuery}"
            )
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
            'a.warehouse_code',
            'a.warehouse_name',
            'a.address',
            'a.is_active',
            'a.created_date'
        ];

        $orderDirection =
            $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy =
            $orderColumn[
                $request->getPost('order')[0]['column'] ?? 4
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

        foreach ($query->getResultArray() as $key => $row) {

            $row['no'] = $start + $key + 1;

            $row['status'] =
                $row['is_active'] == 1
                ? '<span class="badge badge-success">Active</span>'
                : '<span class="badge badge-danger">Inactive</span>';

            $row['action'] = '

                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail" data-id="'.$row['warehouse_id'].'"
                    title="Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="'.base_url().'/warehouse/edit/'.$row['warehouse_id'].'"
                    class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1"
                    title="Edit">
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

    public function create()
    {
        return view('warehouse/create',[
            'title' => 'Create Warehouse',
            'warehouse_code' =>
                $this->generateWarehouseCode()
        ]);
    }

    public function store()
    {
        $rules = [

            'warehouse_name' =>
                'required',

            'latitude' =>
                'permit_empty|decimal',

            'longitude' =>
                'permit_empty|decimal'
        ];

        if(!$this->validate($rules)){

            return $this->response->setJSON([
                'status' => false,
                'message' =>
                    $this->validator->getErrors()
            ]);
        }

        $this->warehouse->insert([

            'warehouse_code' =>
                $this->request->getPost('warehouse_code'),

            'warehouse_name' =>
                $this->request->getPost('warehouse_name'),

            'address' =>
                $this->request->getPost('address'),

            'latitude' =>
                $this->request->getPost('latitude'),

            'longitude' =>
                $this->request->getPost('longitude'),

            'is_active' =>
                $this->request->getPost('is_active'),

            'created_by' =>
                session()->get('user_id')
        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Warehouse berhasil disimpan'
        ]);
    }

    public function detail($id)
    {
        $data['title'] = 'Warehouse Detail';

        $data['views'] = $this->warehouse
            ->where('warehouse_id', $id)
            ->where('is_deleted', 0)
            ->first();

        return view(
            'warehouse/detail', $data
        );
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Warehouse';

        $data['warehouse'] = $this->warehouse
            ->where('warehouse_id', $id)
            ->where('is_deleted', 0)
            ->first();

        return view(
            'warehouse/edit',
            $data
        );
    }

    public function update($id)
    {
        $rules = [
            'warehouse_name' => 'required'
        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([
                'status' => false,
                'message' => $this->validator->getErrors()
            ]);
        }

        $this->warehouse->update($id, [

            'warehouse_name' =>
                $this->request->getPost('warehouse_name'),

            'address' =>
                $this->request->getPost('address'),

            'latitude' =>
                $this->request->getPost('latitude'),

            'longitude' =>
                $this->request->getPost('longitude'),

            'is_active' =>
                $this->request->getPost('is_active'),

            'modified_by' =>
                session()->get('user_id')

        ]);

        return $this->response->setJSON([
            'status' => true,
            'message' => 'Warehouse berhasil diupdate'
        ]);
    }

}