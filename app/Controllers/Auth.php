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
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');
        $base64 = base64_encode($password);
        $user = $this->userModel->getUser($username);
        
        if ($user) {
            if ($user['active'] == 1) {
                //kalau aktif cek password
                if (password_verify($password, $user['password'])) {
                    $data = [
                        'username'    => $user['username'],
                        'users_id'    => $user['users_id'],
                        'fullname'  =>  $user['fullname'],
                        'title'       => $user['title'],
                        'masuk'       => true
                    ];

                    if ($user['title'] == "DRIVER") {

                        $driverId = $this->db->table('driver a')
                            ->select("a.driver_id")
                            ->join('users b', 'a.users_id = b.users_id')
                            ->where('a.users_id', $user['users_id'])
                            ->get()
                            ->getRow();
                        // var_dump($driverId);exit;
                        if (!$driverId) {
                            $this->session->setFlashdata('message', '<div class="alert alert-danger" role="alert">
                            Akun Driver Tidak Terdaftar</div>');
                            return redirect()->to('auth/');
                        }
                    }

                    $this->session->set($data);
                    $username = $user['username'];
                    if ($user['username'] == "$username") {
                        return redirect()->to('Dashboard');
                    }

                } else {
                    $this->session->setFlashdata('message', '<div class="alert alert-danger" role="alert">Username & Password wrong</div>');
                    return redirect()->to('auth');
                }
            } else {
                $this->session->setFlashdata('message', '<div class="alert alert-danger" role="alert">Username & Password wrong
                </div>');
                return redirect()->to('auth');
            }
        } else {
            $this->session->setFlashdata('message', '<div class="alert alert-danger" role="alert">Username Tidak Terdaftar</div>');
            return redirect()->to('auth');
        }
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
