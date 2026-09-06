<?php

namespace App\Controllers\Mobile;

use App\Controllers\BaseController;
use App\Models\UsersModel;

class CollectorMobile extends BaseController
{
    protected UsersModel $usersModel;

    public function __construct()
    {
        $session = \Config\Services::session();

        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: ' . base_url('auth'));
            exit();
        }

        $this->usersModel = new UsersModel();
    }

    public function index()
    {
        return view('mobile/user/home');
    }
}
