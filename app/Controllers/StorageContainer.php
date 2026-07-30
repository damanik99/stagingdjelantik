<?php namespace App\Controllers;

use App\Models\WarehouseModel;
use App\Models\ContainerTypeModel;

class StorageContainer extends BaseController
{
    protected ContainerTypeModel $containertype;
    protected WarehouseModel $warehouse;
    
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
        
    }
    
    public function index()
    {
        $title = 'Storage Container Type';

        $data = [
            'title' => $title,
        ];

        echo view('StorageContainer/index', $data);
    }

    public function create()
    {
        return view('storagecontainer/create');
    }
}