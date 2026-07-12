<?php

namespace App\Controllers;

use App\Models\UsersGroupProgramModel;

class Custom extends BaseController
{
    protected $helpers = [];
    protected UsersGroupProgramModel $usersGroupGrogramModel;

    public function __construct()
    {
        $session = \Config\Services::session();
        if ($session->get('masuk') != true) {
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->usersGroupGrogramModel = new UsersGroupProgramModel();
    }

    public function downloadTemplate($file)
    {
        $name = 'template/'.$file;
        // echo var_dump($name);exit;

        return $this->response->download('teamplate/' . $name, null);
        exit;
    }

}
