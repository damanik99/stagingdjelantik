<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use App\Models\MenusModel;

class LayoutController extends Controller
{
    protected MenusModel $menuModel;

    public function __construct()
    {
        $this->menuModel = new MenusModel();
    }

    
    public function index()
    {
        $program_id = session()->get('program');
        $menuModel = new MenusModel();

        // Ambil data gambar logo program
        $logoData = $menuModel->getProgramLogo($program_id);

        // Ambil data menu berdasarkan program dan role pengguna
        $menuData = $menuModel->getMenu($program_id);

        // Kirim data ke view
        return view('sidebar', [
            'logo' => $logoData,
            'menu' => $menuData
        ]);
    }
}