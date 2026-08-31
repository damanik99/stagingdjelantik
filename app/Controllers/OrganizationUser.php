<?php

namespace App\Controllers;

use App\Models\OrganizationUserModel;
use App\Models\OrganizationModel;
use App\Models\OrganizationProgramModel;
use App\Models\UsersModel;

use App\Models\ImportCsvFormModel;

class OrganizationUser extends BaseController
{
    protected OrganizationUserModel $organizationUserModel;
    protected OrganizationModel $organization;
    protected OrganizationProgramModel $organizationProgram;
    protected UsersModel $users;

    public function __construct()
    {
        $session = \Config\Services::session();

        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: ' . base_url('auth'));
            exit();
        }

        $this->organizationUserModel = new OrganizationUserModel();
        $this->organization = new OrganizationModel();
        $this->users = new UsersModel();
        $this->organizationProgram = new OrganizationProgramModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Organization Users',
            'organizationUsers' => $this->organizationUserModel->findAll(),
        ];

        return view('organizationuser/index', $data);
    }

    public function create()
    {
        $data['orgz'] = $this->organization->getDataOrgPkk();

        return view('organizationuser/create', $data);
    }

    public function save()
    {
        $rules = [
            'organization_program_id' => [
                'label' => 'Organization Program',
                'rules' => 'required|numeric'
            ],
            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[4]|max_length[50]|is_unique[users.username]'
            ],
            'password' => [
                'label' => 'Password',
                'rules' => 'required|min_length[6]'
            ],
            'fullname' => [
                'label' => 'Full Name',
                'rules' => 'required|max_length[100]'
            ],
            'phone' => [
                'label' => 'Phone',
                'rules' => 'permit_empty|max_length[30]'
            ],
            'email' => [
                'label' => 'Email',
                'rules' => 'permit_empty|valid_email|max_length[100]'
            ],
            'address' => [
                'label' => 'Address',
                'rules' => 'permit_empty|max_length[255]'
            ],
            'picture' => [
                'label' => 'Picture',
                'rules' => 'permit_empty|is_image[picture]|mime_in[picture,image/jpg,image/jpeg,image/png]|max_size[picture,2048]'
            ],
        ];

        if (!$this->validate($rules)) {
            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $organizationProgramId = $this->request->getPost('organization_program_id');

        $organizationProgram = $this->organizationProgram
            ->find($organizationProgramId);

        if (!$organizationProgram) {
            return $this->response->setJSON([
                'status' => false,
                'message' => 'Organization Program tidak ditemukan.'
            ]);
        }

        /*
         * Upload picture
         */
        $pictureName = null;

        $picture = $this->request->getFile('picture');

        if ($picture && $picture->isValid() && !$picture->hasMoved()) {

            $pictureName = $picture->getRandomName();

            $uploadPath = ROOTPATH . 'public/upload/image/users';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }

            $picture->move(FCPATH . 'upload/image/users', $pictureName);
        }

        /*
         * Data users
         */
        $userData = [
            'username'     => $this->request->getPost('username'),
            'password'     => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'fullname'     => $this->request->getPost('fullname'),
            'phone'        => $this->request->getPost('phone'),
            'email'        => $this->request->getPost('email'),
            'address'      => $this->request->getPost('address'),
            'picture'      => '/upload/image/users/' . $pictureName,
            'active'       => 1,
            'title'        => 'COLLECTOR',
            'created_date' => date('Y-m-d H:i:s'),
            'created_by'   => session()->get('users_id'),
        ];

        $this->db->transBegin();

        try {

            $this->users->insert($userData);

            $userId = $this->users->getInsertID();

            if (!$userId) {
                throw new \Exception('Gagal membuat user.');
            }

            /*
            * Insert usersgroupprogram
            */
            $usersGroupProgramData = [
                'users_id'     => $userId,
                'group_id'     => 5,
                'program_id'   => $organizationProgram['program_id'],
                'data_level'   => 1,
                'created_date' => date('Y-m-d H:i:s'),
                'created_by'   => session()->get('users_id'),
            ];

            $this->db->table('usersgroupprogram')->insert($usersGroupProgramData);

            if (!$this->db->affectedRows()) {
                throw new \Exception(
                    'Gagal menghubungkan user dengan group program.'
                );
            }

            $organizationUserData = [
                'organization_program_id' => $organizationProgramId,
                'users_id'                => $userId,
                'active'                  => 1,
                'created_date'            => date('Y-m-d H:i:s'),
                'created_by'              => session()->get('users_id'),
            ];

            $this->organizationUserModel->insert($organizationUserData);

            if (!$this->organizationUserModel->getInsertID()) {
                throw new \Exception(
                    'Gagal menghubungkan user dengan organization program.'
                );
            }

            if ($this->db->transStatus() === false) {
                throw new \Exception('Transaction gagal.');
            }

            $this->db->transCommit();

            return $this->response->setJSON([
                'status'   => true,
                'message'  => 'Organization user berhasil dibuat.',
                'redirect' => base_url('OrganizationUser')
            ]);
        } catch (\Throwable $e) {

            $this->db->transRollback();

            if ($pictureName) {

                $filePath = FCPATH . 'uploads/users/' . $pictureName;

                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            log_message(
                'error',
                'Save Organization User Error: ' . $e->getMessage()
            );

            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Gagal menyimpan organization user.'
            ]);
        }
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
            FROM organization_user ou
            LEFT JOIN organization_program op
                ON ou.organization_program_id = op.organization_program_id
            LEFT JOIN organization o
                ON op.organization_id = o.organization_id
            LEFT JOIN program p
                ON op.program_id = p.program_id
            LEFT JOIN users u
                ON ou.users_id = u.users_id
            WHERE op.program_id = ?
        ";

        $filter = "";
        $params = [$program_id];

        if (!empty($search)) {

            $filter .= "
                AND (
                    o.organization_name LIKE ?
                    OR p.name LIKE ?
                    OR u.username LIKE ?
                    OR u.fullname LIKE ?
                    OR u.phone LIKE ?
                    OR u.email LIKE ?
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
            ->query("
                SELECT COUNT(*) cnt
                {$baseQuery}", [$program_id])
            ->getRow()
            ->cnt;

        $totalFiltered = $totalRecords;

        if (!empty($search)) {

            $totalFiltered = $this->db
                ->query(
                    "
                SELECT COUNT(*) cnt
                {$baseQuery}
                {$filter}
                ",
                    $params
                )
                ->getRow()
                ->cnt;
        }

        $orderColumn = [
            'o.organization_name',
            'p.name',
            'u.username',
            'u.fullname',
            'u.phone',
            'u.email',
            'ou.active'
        ];

        $orderRequest = $request->getPost('order');

        $orderIndex = $orderRequest[0]['column'] ?? 0;

        $orderDirection = strtoupper(
            $orderRequest[0]['dir'] ?? 'DESC'
        );

        if (!in_array($orderDirection, ['ASC', 'DESC'])) {
            $orderDirection = 'DESC';
        }

        $orderBy = $orderColumn[$orderIndex] ?? 'ou.organization_user_id';

        $sql = "
            SELECT
                ou.organization_user_id,
                ou.organization_program_id,
                ou.users_id,
                ou.active AS organization_user_active,

                o.organization_id,
                o.organization_name,

                p.program_id,
                p.name,

                u.username,
                u.fullname,
                u.phone,
                u.email,
                u.active AS user_active,
                u.picture

            {$baseQuery}
            {$filter}

            ORDER BY
                {$orderBy} {$orderDirection}

            LIMIT ?, ?
        ";

        $params[] = (int) $start;
        $params[] = (int) $length;

        $query = $this->db->query($sql, $params);

        $data = [];

        foreach ($query->getResultArray() as $row) {

            if ($row['organization_user_active'] == 1) {

                $row['status_badge'] =
                    '<span class="badge badge-success">
                    Active
                </span>';
            } else {

                $row['status_badge'] =
                    '<span class="badge badge-danger">
                    Inactive
                </span>';
            }

            $row['action'] = '
                <a href="javascript:void(0);"
                    class="btn bg-gray-dark btn-sm text-white mb-2 mb-xl-1 btnDetail"
                    data-id="' . $row['organization_user_id'] . '"
                    title="Detail">

                    <i class="fa fa-eye"></i>

                </a>

                <a href="' . base_url('organizationuser/edit/' . $row['organization_user_id']) . '"
                    class="btn btn-cyan btn-sm text-white mb-2 mb-xl-1 btn-edit-organization-user"
                    data-id="' . $row['organization_user_id'] . '"
                    title="Edit">

                    <i class="fa fa-pencil"></i>

                </a>';

            $data[] = $row;
        }

        return $this->response->setJSON([
            "draw"            => intval($draw),
            "recordsTotal"    => $totalRecords,
            "recordsFiltered" => $totalFiltered,
            "data"            => $data
        ]);
    }

    public function upload()
    {
        return view('organizationuser/upload');
    }

    public function uploadOrganizationUser()
    {
        $program_id = session()->get('program');
        $createdby  = session()->get('users_id');

        $model = new ImportCsvFormModel();

        $file_csv = $this->request->getFile('fileexcel');

        $tempLoc = $file_csv->getTempName();

        if ($tempLoc == "" || $tempLoc == NULL) {

            session()->setFlashdata(
                'error',
                'Invalid file, Please select the file'
            );

            return redirect()->to('OrganizationUse/upload');
        }

        $value = $model->arrayValue($tempLoc);

        $ext = $file_csv->getClientExtension();

        if ($ext == 'csv') {

            if ($program_id) {

                $fields = array();
                $returnMessage = array();

                for ($r = 0; $r < count($value); $r++) {

                    $message = '';

                    $fields[] = array_keys($value[$r]);

                    $organizationProgramId  = '';
                    $username               = '';
                    $password               = '';
                    $fullname               = '';
                    $phone                  = '';
                    $email                  = '';
                    $address                = '';

                    for ($p = 0; $p < count($fields[$r]); $p++) {

                        $field  = trim($fields[$r][$p]);
                        $values = trim($value[$r][$field]);

                        $field = preg_replace('/^\xEF\xBB\xBF/', '', $field);

                        /*
                        * ORGANIZATION NAME
                        */
                        if ($field == 'organization_name') {

                            if ($values != '') {

                                $organizationProgramId = $values;
                            } else {

                                $message .= 'ORGANIZATION NAME EMPTY;';
                            }
                        }

                        /*
                        * USERNAME
                        */
                        if ($field == 'username') {

                            if ($values != '') {

                                $username = $values;
                            } else {

                                $message .= 'USERNAME EMPTY;';
                            }
                        }

                        /*
                        * PASSWORD
                        */
                        if ($field == 'password') {

                            if ($values != '') {

                                $password = $values;
                            } else {

                                $message .= 'PASSWORD EMPTY;';
                            }
                        }

                        /*
                        * FULLNAME
                        */
                        if ($field == 'fullname') {

                            if ($values != '') {

                                $fullname = $values;
                            } else {

                                $message .= 'FULLNAME EMPTY;';
                            }
                        }

                        /*
                        * PHONE
                        */
                        if ($field == 'phone') {

                            $phone = $values;
                        }

                        /*
                        * EMAIL
                        */
                        if ($field == 'email') {

                            if ($values != '') {

                                if (filter_var(
                                    $values,
                                    FILTER_VALIDATE_EMAIL
                                )) {

                                    $email = $values;
                                } else {

                                    $message .=
                                        'EMAIL FORMAT INVALID;';
                                }
                            } else {

                                $email = '';
                            }
                        }

                        /*
                        * ADDRESS
                        */
                        if ($field == 'address') {

                            $address = $values;
                        }
                    }

                    /*
                    * ==========================================
                    * VALIDATION DATABASE
                    * ==========================================
                    */

                    if ($message == '') {

                        /*
                        * Organization Program
                        */
                        $organizationProgram =
                            $this->db->table('organization_program op')
                            ->select('op.*, o.organization_name')
                            ->join('organization o', 'op.organization_id = o.organization_id')
                            ->where('organization_name', $organizationProgramId)
                            ->where('program_id', $program_id)->get()->getRow();
                        // var_dump($organizationProgram);
                        // exit;
                        if (!$organizationProgram) {

                            $message .= 'ORGANIZATION PROGRAM NOREG;';
                        }

                        /*
                        * Username
                        */
                        if ($username != '') {

                            $existingUser = $this->db
                                ->table('users')
                                ->where('username', $username)
                                ->get()
                                ->getRow();

                            if ($existingUser) {

                                $message .=
                                    'USERNAME EXIST;';
                            }
                        }
                    }

                    /*
                    * ==========================================
                    * SAVE
                    * ==========================================
                    */

                    if ($message == '') {

                        $this->db->transBegin();

                        try {

                            /*
                            * ==================================
                            * INSERT USERS
                            * ==================================
                            */

                            $userData = [
                                'username'     => $username,
                                'password'     => password_hash($password, PASSWORD_DEFAULT),
                                'fullname'     => $fullname,
                                'phone'        => $phone,
                                'email'        => $email,
                                'address'      => $address,
                                'title'        => 'COLLECTOR',
                                'active'       => 1,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by'   => $createdby
                            ];

                            $this->db->table('users')->insert($userData);

                            $userId = $this->db->insertID();

                            if (!$userId) {

                                throw new \Exception(
                                    'INSERT USERS FAILED;'
                                );
                            }

                            /*
                            * ==================================
                            * INSERT USERS GROUP PROGRAM
                            * ==================================
                            */
                            $usersGroupProgramData = [
                                'users_id'     => $userId,
                                'group_id'     => 5,
                                'program_id'   => $organizationProgram->program_id,
                                'data_level'   => 1,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by'   => $createdby
                            ];

                            $this->db->table('usersgroupprogram')->insert($usersGroupProgramData);

                            if ($this->db->affectedRows() <= 0) {

                                throw new \Exception(
                                    'INSERT USERS GROUP PROGRAM FAILED;'
                                );
                            }

                            /*
                            * ==================================
                            * INSERT ORGANIZATION USERS
                            * ==================================
                            */

                            $organizationUserData = [
                                'organization_program_id' => $organizationProgram->organization_program_id,
                                'users_id' => $userId,
                                'active' => 1,
                                'created_date' => date('Y-m-d H:i:s'),
                                'created_by' => $createdby
                            ];
                            // var_dump($organizationUserData);
                            // exit;
                            $this->db->table('organization_user')->insert($organizationUserData);

                            if ($this->db->affectedRows() <= 0) {

                                throw new \Exception(
                                    'INSERT ORGANIZATION USERS FAILED;'
                                );
                            }

                            /*
                            * ==================================
                            * CHECK TRANSACTION
                            * ==================================
                            */

                            if ($this->db->transStatus() === false) {

                                throw new \Exception(
                                    'TRANSACTION FAILED;'
                                );
                            }

                            /*
                            * COMMIT
                            */
                            $this->db->transCommit();

                            $message .= 'SUCCESS';
                        } catch (\Throwable $e) {

                            /*
                            * ROLLBACK
                            */
                            $this->db->transRollback();

                            log_message(
                                'error',
                                'Organization User Upload: ' . $e->getMessage()
                            );

                            $message .=
                                $e->getMessage();
                        }
                    }

                    /*
                    * ==========================================
                    * RESULT
                    * ==========================================
                    */
                    $returnMessage[] = $message;
                }

                /*
                * ==========================================
                * CREATE RESULT CSV
                * ==========================================
                */
                $file = 'organization_user_Result' . date('Y-m-d');

                $data = $model->importCsv($value, $returnMessage);

                header("Content-type: application/csv");

                header("Content-Disposition: attachment; filename=\"" . $file . ".csv\"");

                header("Pragma: no-cache");
                header("Expires: 0");

                $output = fopen(
                    'php://output',
                    'w'
                );

                fputcsv($output, [
                    'organization',
                    'username',
                    'password',
                    'fullname',
                    'phone',
                    'email',
                    'address',
                    'result'
                ]);

                foreach ($data as $data_array) {

                    fputcsv($output, $data_array);
                }

                fclose($output);

                exit;
            } else {

                session()->setFlashdata(
                    'message',
                    '<div class="alert alert-danger alert-dismissible">
                        <button type="button"
                            class="close"
                            data-dismiss="alert"
                            aria-hidden="true">
                            &times;
                        </button>
                        Warning, Program Belum dipilih
                    </div>'
                );

                return redirect()->to(
                    'OrganizationUser/upload'
                );
            }
        } else {

            session()->setFlashdata(
                'message',
                '<div class="alert alert-danger alert-dismissible">
                    <button type="button"
                        class="close"
                        data-dismiss="alert"
                        aria-hidden="true">
                        &times;
                    </button>
                    Warning, No data in File or No File CSV
                </div>'
            );

            return redirect()->to('OrganizationUser/upload');
        }
    }

    public function detail($id)
    {
        $data = $this->organizationUserModel->detail($id);

        if (empty($data)) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('organizationuser/detail', [
            'views' => $data
        ]);
    }

    public function edit($id)
    {
        $orgz = $this->organization->getDataOrgPkk();
        $data = $this->organizationUserModel->detail($id);

        return view('organizationuser/edit', [
            'data' => $data,
            'orgz' => $orgz
        ]);
    }

    public function saveedit()
    {
        $rules = [
            'organization_user_id' => [
                'label' => 'Organization User',
                'rules' => 'required|numeric'
            ],

            'organization_program_id' => [
                'label' => 'Organization',
                'rules' => 'required|numeric'
            ],

            'username' => [
                'label' => 'Username',
                'rules' => 'required|min_length[4]|max_length[50]'
            ],

            'fullname' => [
                'label' => 'Full Name',
                'rules' => 'required|max_length[100]'
            ],

            'phone' => [
                'label' => 'Phone',
                'rules' => 'permit_empty|max_length[30]'
            ],

            'email' => [
                'label' => 'Email',
                'rules' => 'permit_empty|valid_email|max_length[100]'
            ],

            'address' => [
                'label' => 'Address',
                'rules' => 'permit_empty|max_length[255]'
            ],
        ];

        if (!$this->validate($rules)) {

            return $this->response->setJSON([
                'status' => false,
                'errors' => $this->validator->getErrors()
            ]);
        }

        $organizationUserId = $this->request->getPost('organization_user_id');
        $organizationProgramId = $this->request->getPost('organization_program_id');
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');
        $fullname = trim($this->request->getPost('fullname'));
        $phone = trim($this->request->getPost('phone'));
        $email = trim($this->request->getPost('email'));
        $address = trim($this->request->getPost('address'));

        $createdby = session()->get('users_id');

        /*
     * ==========================================
     * GET ORGANIZATION USER
     * ==========================================
     */

        $organizationUser = $this->db->table('organization_user')->where(
            'organization_user_id',
            $organizationUserId
        )->get()->getRowArray();

        if (!$organizationUser) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Organization user tidak ditemukan.'
            ]);
        }

        $userId = $organizationUser['users_id'];

        /*
     * ==========================================
     * CHECK ORGANIZATION PROGRAM
     * ==========================================
     */

        $organizationProgram = $this->db->table('organization_program')->where(
            'organization_program_id',
            $organizationProgramId
        )->get()->getRowArray();

        if (!$organizationProgram) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Organization program tidak ditemukan.'
            ]);
        }

        /*
        * ==========================================
        * CHECK UNIQUE
        *
        * organization_program_id + users_id
        * ==========================================
        *
        * Jika user yang sama sudah memiliki
        * organization program yang sama pada
        * record lain, tampilkan alert.
        */

        $duplicate = $this->db->table('organization_user')->where(
            'organization_program_id',
            $organizationProgramId
        )->where(
            'users_id',
            $userId
        )->where(
            'organization_user_id !=',
            $organizationUserId
        )->get()->getRow();

        if ($duplicate) {

            return $this->response->setJSON([
                'status' => false,
                'message' =>
                'User sudah terdaftar pada Organization Program tersebut.'
            ]);
        }

        /*
        * ==========================================
        * CHECK USERNAME
        *
        * Username harus unique, tetapi record
        * user yang sedang diedit boleh menggunakan
        * username lamanya.
        * ==========================================
        */

        $existingUsername = $this->db->table('users')
            ->where('username', $username)
            ->where('users_id !=', $userId)
            ->get()->getRow();

        if ($existingUsername) {

            return $this->response->setJSON([
                'status' => false,
                'message' => 'Username sudah digunakan.'
            ]);
        }

        /*
     * ==========================================
     * PICTURE
     * ==========================================
     */

        $pictureName = null;

        $picture = $this->request->getFile('picture');

        if ($picture && $picture->isValid() && !$picture->hasMoved()) {

            $pictureName = $picture->getRandomName();

            $uploadPath = ROOTPATH . 'public/upload/image/users';

            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0775, true);
            }
            $picture->move(FCPATH . 'upload/image/users', $pictureName);
        }

        /*
     * ==========================================
     * TRANSACTION
     * ==========================================
     */
        $this->db->transBegin();
        try {

            /*
         * ======================================
         * UPDATE USERS
         * ======================================
         */
            $userData = [
                'username'     => $username,
                'fullname'     => $fullname,
                'phone'        => $phone,
                'email'        => $email,
                'address'      => $address,
                'modified_date' => date('Y-m-d H:i:s'),
                'modified_by'  => $createdby
            ];

            /* Password hanya di-update jika diisi */
            if ($password !== null && trim($password) !== '') {
                $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            /*
            * Picture hanya di-update jika upload baru
            */
            if ($pictureName !== null) {

                $userData['picture'] = $pictureName;
            }

            $updateUser = $this->db->table('users')->where('users_id', $userId)->update($userData);

            if ($updateUser === false) {

                throw new \Exception(
                    'Gagal update users.'
                );
            }

            /*
         * ======================================
         * UPDATE ORGANIZATION USERS
         * ======================================
         */
            $organizationUserData = [
                'organization_program_id' => $organizationProgramId,
                'users_id' => $userId,
                'modified_date' => date('Y-m-d H:i:s'),
                'modified_by' => $createdby
            ];

            $updateOrganizationUser = $this->db->table('organization_user')
                ->where('organization_user_id', $organizationUserId)
                ->update($organizationUserData);

            if ($updateOrganizationUser === false) {

                throw new \Exception(
                    'Gagal update organization users.'
                );
            }

            /*
         * ======================================
         * CHECK TRANSACTION
         * ======================================
         */

            if ($this->db->transStatus() === false) {

                throw new \Exception(
                    'Transaction gagal.'
                );
            }

            /*
         * ======================================
         * COMMIT
         * ======================================
         */

            $this->db->transCommit();

            return $this->response->setJSON([
                'status' => true,
                'message' => 'Organization user berhasil diperbarui.',
                'redirect' => base_url('/OrganizationUser')
            ]);
        } catch (\Throwable $e) {

            /*
            * ======================================
            * ROLLBACK
            * ======================================
            */

            $this->db->transRollback();

            /*
            * Hapus picture baru jika transaction gagal
            */

            if ($pictureName) {

                $filePath = FCPATH . 'upload/image/users/' . $pictureName;

                if (is_file($filePath)) {
                    unlink($filePath);
                }
            }

            log_message(
                'error',
                'Edit Organization User Error: ' .
                    $e->getMessage()
            );

            return $this->response->setJSON([
                'status' => false,
                'message' => $e->getMessage()
            ]);
        }
    }
}
