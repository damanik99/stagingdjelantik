<?php

namespace App\Controllers;

use App\Models\LoginModel;
use App\Models\ModuleUpdateModel;
use CodeIgniter\API\ResponseTrait;

class Auth extends BaseController
{
    protected $helpers = [];
    protected $userModel;

    public function __construct()
    {
        helper(['url', 'form']);
        $this->userModel  = new LoginModel();
    }

    public function index()
    {
        // Cek apakah sesi sudah ada
        if (session()->get('masuk')) {
            return redirect()->to('/Dashboard');
        }

        $data = [
            'title' => 'Login System',
        ];

        echo view('auth/login', $data);
    }

    public function ceklogin()
    {
        $username = trim($this->request->getPost('username'));
        $password = $this->request->getPost('password');

        // =========================================================
        // 1. VALIDASI INPUT
        // =========================================================
        if ($username === '' || $password === '') {

            $this->session->setFlashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                    Username dan Password wajib diisi
                </div>'
            );

            return redirect()->to('auth');
        }


        // =========================================================
        // 2. CARI USER
        // =========================================================
        $user = $this->userModel->getUser($username);

        if (!$user) {

            $this->session->setFlashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                    Username Tidak Terdaftar
                </div>'
            );

            return redirect()->to('auth');
        }


        // =========================================================
        // 3. CEK STATUS USER
        // =========================================================
        if ((int) $user['active'] !== 1) {

            $this->session->setFlashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                    Akun tidak aktif
                </div>'
            );

            return redirect()->to('auth');
        }

        // =========================================================
        // 4. CEK PASSWORD
        // =========================================================
        if (!password_verify($password, $user['password'])) {

            $this->session->setFlashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                    Username & Password wrong
                </div>'
            );

            return redirect()->to('auth');
        }

        // =========================================================
        // 5. REGENERATE SESSION
        // =========================================================
        $this->session->regenerate();


        // =========================================================
        // 6. SET SESSION USER
        // =========================================================
        $this->session->set([
            'users_id'     => $user['users_id'],
            'username'     => $user['username'],
            'fullname'     => $user['fullname'],
            'title'        => $user['title'],
            'masuk' => true,
        ]);

        // =========================================================
        // SET ACTIVE PROGRAM
        // =========================================================
        $userId = $user['users_id'];

        $currentProgramId = $this->session->get('program');

        // Ambil semua program yang dimiliki user
        $programs = $this->db->table('usersgroupprogram a')
            ->select('a.program_id, b.name')
            ->join('program b', 'b.program_id = a.program_id')
            ->where('a.users_id', $userId)
            ->groupBy('a.program_id')
            ->orderBy('b.created_date', 'ASC')
            ->get()
            ->getResultArray();

        if (empty($programs)) {

            $this->session->setFlashdata(
                'message',
                '<div class="alert alert-danger" role="alert">
                    User belum memiliki program
                </div>'
            );

            return redirect()->to('auth');
        }

        $selectedProgram = null;

        // Cek apakah program yang ada di session masih dimiliki user
        if (!empty($currentProgramId)) {

            foreach ($programs as $program) {

                if ((int) $program['program_id'] === (int) $currentProgramId) {
                    $selectedProgram = $program;
                    break;
                }
            }
        }

        // Jika session kosong atau program sudah tidak punya akses,
        // gunakan program terbaru
        if (!$selectedProgram) {
            $selectedProgram = $programs[0];
        }

        // Set active program
        $this->session->set([
            'program'     => $selectedProgram['program_id'],
            'nameprogram' => $selectedProgram['name'],
        ]);


        // =========================================================
        // 7. DRIVER → MOBILE WEB
        // =========================================================
        if ($user['title'] === 'DRIVER') {

            $driver = $this->db->table('driver')
                ->select('driver_id')
                ->where('users_id', $user['users_id'])
                ->get()
                ->getRowArray();

            if (!$driver) {

                $this->session->destroy();

                $this->session->setFlashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">
                        Akun Driver Tidak Terdaftar
                    </div>'
                );

                return redirect()->to('auth');
            }

            // Driver ID hanya context untuk kebutuhan modul driver
            $this->session->set([
                'driver_id' => $driver['driver_id']
            ]);

            return redirect()->to('driver/index');
        } elseif ($user['title'] == 'COLLECTOR') {

            $users = $this->db->table('users')
                ->where('users_id', $user['users_id'])
                ->get()->getRowArray();

            if (!$users) {
                $this->session->destroy();

                $this->session->setFlashdata(
                    'message',
                    '<div class="alert alert-danger" role="alert">
                        Akun Driver Tidak Terdaftar
                    </div>'
                );

                return redirect()->to('auth');
            }

            // Driver ID hanya context untuk kebutuhan modul driver
            $this->session->set([
                'title' => 'COLLECTOR'
            ]);

            return redirect()->to('mobile/user/home');
        }

        $redirectUrl = session()->get('redirect_url');

        session()->remove('redirect_url');

        return redirect()->to(
            $redirectUrl ?: base_url('Dashboard')
        );


        // =========================================================
        // 8. USER WEB ADMIN
        // =========================================================
        return redirect()->to('/Dashboard');
    }

    public function logout()
    {
        session()->setFlashdata('message', '<div class="alert alert-success" role="alert">Anda telah log out!</div>');
        session()->remove('username');
        session()->remove('users_id');
        session()->remove('masuk');
        session()->destroy();
        return redirect()->to('auth');
    }
}
