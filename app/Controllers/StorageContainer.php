<?php namespace App\Controllers;

use App\Models\StorageContainerModel;
use App\Models\WarehouseModel;
use App\Models\ContainerTypeModel;
use App\Models\CustomModel;

class StorageContainer extends BaseController
{
    protected ContainerTypeModel $containertype;
    protected WarehouseModel $warehouse;
    protected StorageContainerModel $storagecontainer;
    protected CustomModel $custom;
    
    public function __construct()
    {
        $session = \Config\Services::session();
        if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->warehouse = new WarehouseModel();
        $this->containertype = new ContainerTypeModel();
        $this->storagecontainer = new StorageContainerModel();
        $this->custom = new CustomModel();
        
    }
    
    public function index()
    {
        $title = 'Storage Container Type';

        $data = [
            'title' => $title,
        ];

        echo view('storagecontainer/index', $data);
    }

    public function create()
    {
        $status = $this->db->table('status')->where('module', 'STORAGE')->get()->getResultArray();
        $warehouse = $this->warehouse->dataWarehouse();
        $containertype = $this->db->table('container_type')->get()->getResultArray();
        $containercode = $this->custom->setIdRandomString('storage_container', 'container_code', '10', 'String', 'SC');

        $data = [
            'warehouse' => $warehouse,
            'containertype' => $containertype,
            'containercode' => $containercode,
            'status' => $status
        ];
        return view('storagecontainer/create', $data);
    }

    public function save()
    {
        $rules = [
            'container_code' => [
                'label' => 'Container Code',
                'rules' => 'required|max_length[30]|is_unique[storage_container.container_code]',
            ],
            'container_name' => [
                'label' => 'Container Name',
                'rules' => 'required|max_length[100]',
            ],
            'container_type_id' => [
                'label' => 'Container Type',
                'rules' => 'required|integer',
            ],
            'warehouse_id' => [
                'label' => 'Warehouse',
                'rules' => 'required|integer',
            ],
            'capacity' => [
                'label' => 'Capacity',
                'rules' => 'required|decimal|greater_than[0]',
            ],
            'capacity_unit' => [
                'label' => 'Capacity Unit',
                'rules' => 'required|max_length[20]',
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $this->db->transStart();

        $data = [
            'container_code'    => strtoupper(trim($this->request->getPost('container_code'))),
            'container_name'    => trim($this->request->getPost('container_name')),
            'container_type_id' => $this->request->getPost('container_type_id'),
            'warehouse_id'      => $this->request->getPost('warehouse_id'),
            'capacity'          => $this->request->getPost('capacity'),
            'capacity_unit'     => strtoupper(trim($this->request->getPost('capacity_unit'))),
            'status_id'         => 1, // Active (sesuaikan dengan master status)
            'created_by'        => session()->get('users_id'),
        ];

        $this->storagecontainer->insert($data);

        $this->db->transComplete();

        if (!$this->db->transStatus()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data gagal disimpan.'
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }

    public function datatables()
    {
        $request = service('request');

        $draw   = $request->getPost('draw');
        $start  = $request->getPost('start');
        $length = $request->getPost('length');
        $search = $request->getPost('search')['value'] ?? '';

        $program_id = session()->get('program');

        $baseQuery = "
            FROM storage_container a
            JOIN container_type b
                ON a.container_type_id = b.container_type_id
            JOIN warehouse c
                ON a.warehouse_id = c.warehouse_id
            LEFT JOIN status d
                ON a.status_id = d.status_id
            WHERE c.program_id = ?
        ";

        $filter = "";
        $params = [$program_id];

        if (!empty($search)) {

            $filter .= "
                AND (
                    a.container_code LIKE ?
                    OR a.container_name LIKE ?
                    OR b.container_type_name LIKE ?
                    OR c.warehouse_name LIKE ?
                    OR d.status_name LIKE ?
                    OR a.capacity LIKE ?
                    OR a.capacity_unit LIKE ?
                )
            ";

            for ($i = 0; $i < 7; $i++) {
                $params[] = "%{$search}%";
            }
        }

        $totalRecords = $this->db
            ->query(
                "SELECT COUNT(*) cnt {$baseQuery}",
                [$program_id]
            )->getRow()->cnt;

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
            'a.container_code',
            'a.container_name',
            'b.container_type_name',
            'c.warehouse_name',
            'a.capacity',
            'd.status_name',
            'a.created_date'
        ];

        $orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';

        $orderBy = $orderColumn[
            $request->getPost('order')[0]['column'] ?? 6
        ];

        $sql = "
            SELECT
                a.*,
                b.container_type_name,
                c.warehouse_name,
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

            $row['capacity_display'] = number_format($row['capacity'], 0, ',', '.')
                .' '.$row['capacity_unit'];

            switch ($row['status_code']) {
                case 'AVB':
                    $row['status_badge'] =
                        '<span class="badge badge-success">'.$row['status_name'].'</span>';
                    break;

                case 'MNTC':
                    $row['status_badge'] =
                        '<span class="badge badge-danger">'.$row['status_name'].'</span>';
                    break;

                case 'CLNG':
                    $row['status_badge'] =
                        '<span class="badge badge-danger">'.$row['status_name'].'</span>';
                    break;

                default:
                    $row['status_badge'] =
                        '<span class="badge badge-secondary">'.$row['status_name'].'</span>';
                    break;
            }

            $row['action'] = '

                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white btnDetail"
                    data-id="'.$row['storage_container_id'].'"
                    title="Detail">
                    <i class="fa fa-eye"></i>
                </a>

                <a href="javascript:void(0);"
                    class="btn btn-cyan btn-sm text-white btnEdit"
                    data-id="'.$row['storage_container_id'].'"
                    title="Edit">
                    <i class="fa fa-pencil"></i>
                </a>

            ';

            $data[] = $row;
        }

        return $this->response->setJSON([
            'draw'            => intval($draw),
            'recordsTotal'    => $totalRecords,
            'recordsFiltered' => $totalFiltered,
            'data'            => $data
        ]);
    }

    public function detail($id)
    {
        $data['title'] = 'Storage Container Detail';

        $data['views'] = $this->db->table('storage_container a')
            ->select('
                a.*,
                b.container_type_name,
                c.warehouse_name,
                d.status_code,
                d.status_name
            ')
            ->join('container_type b', 'a.container_type_id = b.container_type_id', 'left')
            ->join('warehouse c', 'a.warehouse_id = c.warehouse_id', 'left')
            ->join('status d', 'a.status_id = d.status_id', 'left')
            ->where('a.storage_container_id', $id)
            ->where('a.is_deleted', 0)
            ->get()
            ->getRowArray();

        return view('storagecontainer/detail', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Storage Container';

        $data['container'] = $this->db->table('storage_container a')
            ->select('
                a.*,
                b.container_type_name,
                c.warehouse_name,
                d.status_code,
                d.status_name
            ')
            ->join('container_type b', 'a.container_type_id = b.container_type_id', 'left')
            ->join('warehouse c', 'a.warehouse_id = c.warehouse_id', 'left')
            ->join('status d', 'a.status_id = d.status_id', 'left')
            ->where('a.storage_container_id', $id)
            ->where('a.is_deleted', 0)
            ->get()
            ->getRowArray();

        if (empty($data['container'])) {
            return redirect()->to(base_url('StorageContainer'));
        }

        $data['warehouse'] = $this->warehouse->dataWarehouse();
        $data['containertype'] = $this->db->table('container_type')->get()->getResultArray();
        $data['status'] = $this->db->table('status')->where('module', 'STORAGE')->get()->getResultArray();

        return view('storagecontainer/edit', $data);
    }

    public function update($id)
    {
        $payload = $this->request->getJSON(true);
        $payload = is_array($payload) ? $payload : [];

        $rules = [
            'container_code' => [
                'label' => 'Container Code',
                'rules' => 'required|max_length[30]',
            ],
            'container_name' => [
                'label' => 'Container Name',
                'rules' => 'required|max_length[100]',
            ],
            'container_type_id' => [
                'label' => 'Container Type',
                'rules' => 'required|integer',
            ],
            'warehouse_id' => [
                'label' => 'Warehouse',
                'rules' => 'required|integer',
            ],
            'capacity' => [
                'label' => 'Capacity',
                'rules' => 'required|decimal|greater_than[0]',
            ],
            'capacity_unit' => [
                'label' => 'Capacity Unit',
                'rules' => 'required|max_length[20]',
            ],
            'status' => [
                'label' => 'Status',
                'rules' => 'required|integer',
            ],
        ];

        if (!$this->validateData($payload, $rules)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Validasi gagal.',
                'errors'  => $this->validator->getErrors(),
            ]);
        }

        $existing = $this->storagecontainer
            ->where('storage_container_id', $id)
            ->where('is_deleted', 0)
            ->first();

        if (empty($existing)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data storage container tidak ditemukan.',
            ]);
        }

        $duplicate = $this->storagecontainer
            ->where('container_code', strtoupper(trim($payload['container_code'])))
            ->where('storage_container_id !=', $id)
            ->where('is_deleted', 0)
            ->first();

        if (!empty($duplicate)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Container code sudah digunakan.',
                'errors'  => ['container_code' => 'Container code sudah digunakan.'],
            ]);
        }

        $this->db->transStart();

        $this->storagecontainer->update($id, [
            'container_code'    => strtoupper(trim($payload['container_code'])),
            'container_name'    => trim($payload['container_name']),
            'container_type_id' => $payload['container_type_id'],
            'warehouse_id'      => $payload['warehouse_id'],
            'capacity'          => $payload['capacity'],
            'capacity_unit'     => strtoupper(trim($payload['capacity_unit'])),
            'status_id'         => $payload['status'],
            'note'              => $payload['note'],
            'modified_by'       => session()->get('users_id'),
            'modified_date'     => date('Y-m-d H:i:s'),
        ]);

        $this->db->transComplete();

        if (!$this->db->transStatus()) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data gagal diupdate.',
            ]);
        }

        return $this->response->setJSON([
            'status'  => true,
            'message' => 'Data berhasil diupdate.',
        ]);
    }
}
