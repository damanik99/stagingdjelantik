<?php namespace App\Models;

use CodeIgniter\Model;

class ModuleUpdateModel extends Model
{
    protected $table = 'module_updates';
    protected $primaryKey = 'module_updates_id';
    protected $allowedFields = ['message', 'type', 'created_date', 'modified_date', 'version', 'created_by', 'modified_by',
    'created_by'];

    public function getValidNotif()
    {
        return $this->where('created_date >=', date('Y-m-d H:i:s', strtotime('-7 days')))
                    ->findAll();
    }

    function dataVersion()
    {
        $db      = \Config\Database::connect();
        $builder = $db->table('module_updates');
        $query = $builder->orderBy('created_date', 'DESC')
                        ->limit(1)
                        ->get();

        $result = $query->getRow(); 
        return $result;
    }
}