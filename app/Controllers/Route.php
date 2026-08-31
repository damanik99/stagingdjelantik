<?php

namespace App\Controllers;

use App\Models\RouteModel;
use App\Models\PageModel;
use App\Models\ActionModel;

class Route extends BaseController
{
    protected RouteModel $routeModel;
    protected PageModel $pageModel;
    protected ActionModel $actionModel;

    public function __construct()
    {
        $this->routeModel  = new RouteModel();
        $this->pageModel   = new PageModel();
        $this->actionModel = new ActionModel();
    }

    public function index()
    {
        return view('route/index');
    }

    /**
     * Form create route
     */
    public function create()
    {
        $pages = $this->pageModel->orderBy('name', 'ASC')->findAll();

        $actions = $this->actionModel
            ->whereIn('name', [
                'view',
                'create',
                'edit',
                'delete',
                'admin',
            ])->orderBy('action_id', 'ASC')->findAll();

        return view('route/create', [
            'pages'   => $pages,
            'actions' => $actions,
        ]);
    }

    /**
     * Save route
     */
    public function save()
    {
        $pageId     = (int) $this->request->getPost('page_id');
        $actionId   = (int) $this->request->getPost('action_id');
        $uri        = trim((string) $this->request->getPost('uri'));
        $httpMethod = strtoupper(
            trim((string) $this->request->getPost('http_method'))
        );
        $controller = trim(
            (string) $this->request->getPost('controller')
        );
        $method     = trim(
            (string) $this->request->getPost('method')
        );

        /*
         * =====================================================
         * VALIDATION
         * =====================================================
         */
        if ($pageId <= 0) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Page wajib dipilih.');
        }

        if ($actionId <= 0) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Action wajib dipilih.');
        }

        if ($uri === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'URI wajib diisi.');
        }

        if ($controller === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Controller wajib diisi.');
        }

        if ($method === '') {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Method wajib diisi.');
        }

        $allowedHttpMethod = [
            'GET',
            'POST',
            'PUT',
            'PATCH',
            'DELETE',
        ];

        if (!in_array($httpMethod, $allowedHttpMethod, true)) {
            return redirect()->back()->withInput()->with('error', 'HTTP Method tidak valid.');
        }

        /*
         * =====================================================
         * PAGE EXIST
         * =====================================================
         */
        $page = $this->pageModel->find($pageId);

        if (!$page) {
            return redirect()->back()->withInput()->with('error', 'Page tidak ditemukan.');
        }

        /*
         * =====================================================
         * ACTION EXIST
         * =====================================================
         */
        $action = $this->actionModel->find($actionId);

        if (!$action) {
            return redirect()->back()->withInput()->with('error', 'Action tidak ditemukan.');
        }

        /*
         * =====================================================
         * NORMALIZE URI
         * =====================================================
         */

        $uri = trim($uri, '/');

        /*
         * =====================================================
         * DUPLICATE CHECK
         *
         * URI + HTTP METHOD harus unik.
         * =====================================================
         */

        $duplicate = $this->routeModel
            ->where('uri', $uri)
            ->where('http_method', $httpMethod)
            ->first();

        if ($duplicate) {
            return redirect()->back()->withInput()
                ->with('error', 'Route dengan URI dan HTTP Method tersebut sudah ada.');
        }

        /*
         * =====================================================
         * INSERT
         * =====================================================
         */
        $now = date('Y-m-d H:i:s');

        $data = [
            'page_id'      => $pageId,
            'action_id'    => $actionId,
            'uri'          => $uri,
            'http_method'  => $httpMethod,
            'controller'   => $controller,
            'method'       => $method,
            'created_date' => $now,
            'modified_date' => $now,
            'created_by'   => session()->get('users_id'),
            'modified_by'  => session()->get('users_id'),
        ];

        if (!$this->routeModel->insert($data)) {
            return redirect()->back()->withInput()
                ->with(
                    'error',
                    'Gagal menyimpan route.'
                );
        }

        return redirect()->to(base_url('route'))
            ->with('success', 'Route berhasil disimpan.');
    }

    public function datatables() {}
}
