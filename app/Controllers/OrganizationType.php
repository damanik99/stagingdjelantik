<?php

namespace App\Controllers;

use App\Models\OrganizationModel;
use App\Models\OrganizationTypeModel;
use App\Models\CompanyProgramModel;
use App\Models\StatusModel;
use App\Models\ProvinceModel;

class OrganizationType extends BaseController
{
    protected OrganizationModel $organization;
    protected OrganizationTypeModel $OrganizationType;
    protected CompanyProgramModel $companyProgram;
    protected StatusModel $status;

    protected ProvinceModel $provinceModel;

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

        $this->provinceModel  = new ProvinceModel();
    }

    public function index()
    {
        $data['organizationType'] = $this->db->table('organization_type')->get()->getResultArray();

        return view('organizationtype/index', $data);
    }
}