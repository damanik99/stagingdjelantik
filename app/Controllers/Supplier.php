<?php namespace App\Controllers;

use App\Models\SaveModel;
use App\Models\SupplierModel;

class Supplier extends BaseController
{
    
    public function __construct()
    {
        $session = \Config\Services::session();
        if($session->get('masuk') != TRUE ){
            session()->setFlashdata('message', '<div class="alert alert-danger" role="alert">Maaf! Anda tidak memiliki hak akses ke sini! </div>');
            header('Location: '.base_url('auth'));
            exit();
        }

        $this->supplierModel = new SupplierModel();
        $this->saveModel = new SaveModel();
        
        helper(['url', 'form']);
    }
    
    public function index()
    {
        $data = ['title' => 'Supplier'];
        $data['datasupplier'] = $this->_view_datasupplier();
        echo view('/supplier/index_view', $data);
    }
    
    
    function _view_datasupplier()
    { 
        $sql  = "SELECT DATE(a.created_date) AS tgl_buat,a.supplier_id,a.company,a.name,a.phone,a.email,b.name AS city FROM supplier a, city b WHERE a.city_id=b.city_id ORDER BY tgl_buat DESC";
        $query = $this->db->query($sql);
        $result = $query->getResultArray();
        return $result;
    }
    
    public function add()
    {
        $data = ['title' => 'Supplier Add'];
        $data['datacity']    = $this->_view_datacity();
        echo view('/supplier/index_add', $data);
    }
    
    function _view_datacity()
    { 
        $sql  = "SELECT * FROM city ORDER BY name ASC";
        $query = $this->db->query($sql);
        $result = $query->getResult();
        return $result;
    }
    
    public function save()
    {
        $model = new SaveModel();     
        $data  = array(
            'company'       => $this->request->getPost('company'),
            'email'         => $this->request->getPost('email'),
            'city_id'       => $this->request->getPost('city'),
            'name'          => $this->request->getPost('contacname'),
            'phone'         => $this->request->getPost('phone'),
            'address'       => $this->request->getPost('adress'),
            'created_date'  => date("Y-m-d H:i:s"),
            'created_by'    => session()->get('users_id')

        );
        
        $model->saveSupplier($data);
        session()->setFlashdata('success', 'Data berhasil di simpan');
        return redirect()->to('/supplier/add/');
    }

    public function edit($id)
    {
        $datasupplier = $this->datasupplier($id);

        $data = [
			'title' => 'Edit',
            'datacity' => $this->_view_datacity(),
            'datasupplier' => $datasupplier
		];

        return view('/supplier/edit', $data);
    }

    public function saveedit($id)
    {
        $createdby  = session()->get('users_id');
        $model = new SupplierModel();

        $model->update($id, [
            "company"          => $this->request->getPost('company'),
            "name"          => $this->request->getPost('contact'),
            "phone"            => $this->request->getPost('phone'),
            "email"            => $this->request->getPost('email'),
            "city_id"          => $this->request->getPost('city'),
            "address"          => $this->request->getPost('address'),
            "created_date"     => date("Y-m-d H:i:s"),
            "modified_date"    => date("Y-m-d H:i:s"),
            "modified_by"       => $createdby
        ]);

        session()->setFlashdata('success', 'Data berhasil di Update');
        return redirect()->to('/supplier');
    }

    public function view($id = NULL)
    {
        if ($id == NULL) 
        {
            echo view('/supplier/forbidden');
        }
        else
        {
            $views = $this->supplierModel->viewsupplier($id);
            $data  = array(
                'title'    => 'INFORMATION',
                'views'     => $views
            );
            
            echo view('/supplier/view', $data);
        }
    }

    public function datasupplier($id)
    {
        $query = $this->db->query('SELECT supplier_id, supplier.city_id AS city_id, supplier.name, company, phone, email, `address`, city.name AS city FROM supplier JOIN city ON supplier.city_id = city.city_id where supplier_id ='.$id);

        return $query->getRowArray();
    }
    
    public function delete($id)
    {
        $this->db->table('supplier')->delete(array('supplier_id' => $id));
        session()->setFlashdata('delete', 'Data berhasil di hapus');
        return redirect()->to('/supplier');
    }
}