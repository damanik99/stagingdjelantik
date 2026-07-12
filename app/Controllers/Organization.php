<?php

namespace App\Controllers;

use App\Models\OrganizationModel;
use App\Models\OrganizationTypeModel;
use App\Models\CompanyProgramModel;
use App\Models\StatusModel;

class Organization extends BaseController
{
    protected OrganizationModel $organization;
    protected OrganizationTypeModel $OrganizationType;
    protected CompanyProgramModel $companyProgram;
    protected StatusModel $status;

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
    }

    public function index()
    {
        $data['organizationType'] = $this->OrganizationType->findAll();

        return view('organization/index', $data);
    }

    public function create()
    {
        return view('organization/create');
    }

}