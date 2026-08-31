<?php

namespace App\Controllers;

use App\Models\PrivilegeModel;
use App\Models\DatalistModel;
use App\Models\ActionModel;
use App\Models\PageModel;

class Privilege extends BaseController
{
    protected PrivilegeModel $privilegeModel;
    protected DatalistModel $datalistModel;
    protected PageModel $pageModel;
    protected ActionModel $actionModel;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != TRUE) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: ' . base_url('auth'));
            exit();
        }

        $this->privilegeModel = new PrivilegeModel();
        $this->datalistModel = new DatalistModel();
        $this->pageModel = new PageModel();
        $this->actionModel = new ActionModel;
    }

    public function index()
    {

        $groups = $this->db->table('group')
            ->orderBy('name', 'ASC')
            ->get()
            ->getResultArray();

        $pages   = $this->pageModel->getAllPages();
        $actions = $this->actionModel->getPermissionActions();
        // var_dump($actions);
        // exit;
        return view('privilege/index', [
            'groups'  => $groups,
            'pages'   => $pages,
            'actions' => $actions,
        ]);
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
			FROM privilege a
			JOIN `group` b ON a.`group_id` = b.`group_id`
			JOIN page c ON a.`page_id` = c.`page_id`
			JOIN `action` d ON a.`action_id` = d.`action_id`";

        // Filtering
        $filter = "";
        $params = [];
        if (!empty($search)) {
            $filter = " AND (
                b.name LIKE ? OR 
                c.name LIKE ? OR
                d.name LIKE ? OR 
                e.name LIKE ?
			)";
            for ($i = 0; $i < 4; $i++) $params[] = "%$search%";
        }

        // Total records
        $totalRecords = $this->db->query("SELECT COUNT(*) as cnt $baseQuery")->getRow()->cnt;

        $totalFiltered = $totalRecords;
        if (!empty($search)) {
            $totalFiltered =   $this->db->query("SELECT COUNT(*) as cnt $baseQuery $filter", $params)->getRow()->cnt;
        }

        $orderColumn = ['b.name', 'c.name', 'd.name', 'e.name']; // Sesuaikan dengan kolom
        $orderDirection = $request->getPost('order')[0]['dir'] ?? 'DESC';
        $orderBy = $orderColumn[$request->getPost('order')[0]['column']] ?? 'a.created_date';

        // Data query
        $sql = "SELECT b.name AS 'group', c.name AS page, d.name AS 'actions', a.created_date, a.privilege_id
		$baseQuery $filter 
		ORDER BY $orderBy $orderDirection
		LIMIT ?, ?";

        $params[] = (int)$start;
        $params[] = (int)$length;
        $query = $this->db->query($sql, $params);
        $data = [];
        // echo var_dump($query);exit;
        foreach ($query->getResultArray() as $row) {
            $row['action'] = '
                <a href="' . base_url() . '/privilege/edit/' . $row['privilege_id'] . '" class="badge badge-pill badge-success" title="Edit"><i class="fa fa-pencil"></i></a>
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

    public function getByGroup()
    {
        $groupId = (int) $this->request->getPost('group_id');

        if ($groupId <= 0) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Group tidak valid.',
            ]);
        }

        $privileges = $this->privilegeModel->getPrivilegesByGroup($groupId);

        $permission = [];

        foreach ($privileges as $row) {
            $permission[$row['page_id'] . '_' . $row['action_id']] = true;
        }

        return $this->response->setJSON([
            'status'     => true,
            'permission' => $permission,
        ]);
    }

    public function indexs()
    {
        $program_id = session()->get('program');
        $privilege = $this->privilegeModel->index($program_id);
        $group = $this->datalistModel->dataGroup($program_id);
        $page = $this->datalistModel->dataPage();
        $action = $this->datalistModel->dataAction();
        // echo var_dump($privilege);exit;
        $data = [
            'title'     => 'Privilege',
            'privilege' => $privilege,
            'group' => $group,
            'page' => $page,
            'action' => $action
        ];

        return view('privilege/index', $data);
    }

    public function create()
    {
        $program_id = session()->get('program');

        $group = $this->privilegeModel->group($program_id);
        $page = $this->datalistModel->dataPage();
        $action = $this->datalistModel->dataAction();

        if ($this->request->getMethod() == 'post') {
        }

        $data = [
            'title' => 'Form Create privilege',
            'groups' => $group,
            'pages' => $page,
            'actions' => $action
        ];

        return view('privilege/create', $data);
    }

    public function save()
    {
        $groupId     = (int) $this->request->getPost('group_id');
        $permissions = $this->request->getPost('permission') ?? [];

        if ($groupId <= 0) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Group wajib dipilih.',
            ]);
        }

        /*
         * Administrator tidak perlu disimpan ke privilege.
         */
        $group = db_connect()
            ->table('group')
            ->where('group_id', $groupId)
            ->get()
            ->getFirstRow();

        if (
            $group &&
            strtoupper(trim($group->name)) === 'ADMINISTRATOR'
        ) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Group ADMINISTRATOR memiliki seluruh permission.',
            ]);
        }

        $db = db_connect();

        try {

            $db->transStart();

            /*
             * Hapus permission lama.
             */
            $db->table('privilege')
                ->where('group_id', $groupId)
                ->delete();

            /*
             * Insert permission baru.
             */
            $privilegeData = [];

            foreach ($permissions as $permission) {

                if (!is_array($permission)) {
                    continue;
                }

                $pageId   = (int) ($permission['page_id'] ?? 0);
                $actionId = (int) ($permission['action_id'] ?? 0);

                if ($pageId <= 0 || $actionId <= 0) {
                    continue;
                }

                $privilegeData[] = [
                    'group_id'     => $groupId,
                    'page_id'      => $pageId,
                    'action_id'    => $actionId,
                    'created_date' => date('Y-m-d H:i:s'),
                    'modified_date' => date('Y-m-d H:i:s'),
                    'created_by'   => session()->get('users_id'),
                    'modified_by'  => session()->get('users_id'),
                ];
            }

            if (!empty($privilegeData)) {
                $db->table('privilege')
                    ->insertBatch($privilegeData);
            }

            /*
             * Pastikan route global tersedia.
             */
            $this->syncRoutes();

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \RuntimeException(
                    'Gagal menyimpan permission.'
                );
            }

            return $this->response->setJSON([
                'status'  => true,
                'message' => 'Permission berhasil disimpan.',
            ]);
        } catch (\Throwable $e) {

            $db->transRollback();

            log_message(
                'error',
                'Privilege::save - ' . $e->getMessage()
            );

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Gagal menyimpan permission.',
            ]);
        }
    }

    protected function syncRoutes(): void
    {
        /*
         * Route adalah global berdasarkan Page + Action,
         * bukan berdasarkan Group.
         *
         * Untuk sementara method ini hanya memastikan
         * struktur route tetap tersedia.
         */
    }
}
