<?php

namespace App\Controllers;

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 *
 * @package CodeIgniter
 */

use CodeIgniter\Controller;

class BaseController extends Controller
{
    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var array
     */
    protected $helpers = [];
    /**
     * @var \CodeIgniter\HTTP\IncomingRequest
     * @property \CodeIgniter\HTTP\Response $response
    */
    protected $request;
    protected $writer;
    protected $db;
    protected $session;
    protected $validation;
    /**
     * Constructor.
     */
    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        //--------------------------------------------------------------------
        // Preload any models, libraries, etc, here.
        //--------------------------------------------------------------------
        // E.g.:
        $this->session         = \Config\Services::session();
        $this->db              = \Config\Database::connect();
        $this->validation      = \Config\Services::validation();
        helper('permission');
    }

    protected function exportCsv(array $data, string $fileName = 'export')
    {
        if (empty($data)) {
            return redirect()->back()->with('error', 'Data kosong');
        }

        $fileName = $fileName . '_' . date('Ymd_His') . '.csv';

        $handle = fopen('php://temp', 'r+');

        // Header
        fputcsv($handle, array_keys($data[0]));

        // Data
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }

        rewind($handle);
        $csv = stream_get_contents($handle);
        fclose($handle);

        $response = $this->response;

        $response->download($fileName, $csv, true);

        // return $this->response
        //     ->setHeader('Content-Type', 'text/csv')
        //     ->setHeader('Content-Disposition', 'attachment; filename="' . $fileName . '"')
        //     ->setBody($csv);
    }

    protected function checkSession()
    {
        if (!session()->get('masuk')) {
            return redirect()->to('/auth');
        }

        $expired = config('App')->sessionExpiration;

        // cek timeout
        if ((time() - session('last_activity')) > $expired) {

            session()->destroy();

            return redirect()->to('/auth');
        }

        // update aktivitas terakhir
        session()->set('last_activity', time());
    }


}
