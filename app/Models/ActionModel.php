<?php

namespace App\Models;

use CodeIgniter\Model;

class ActionModel extends Model
{
    protected $table      = 'action';
    protected $primaryKey = 'action_id';

    protected $allowedFields = ['name', 'created_date', 'modified_date', 'created_by', 'modified_by'];

    public function getPermissionActions(): array
    {
        return $this
            ->whereIn('name', [
                'view',
                'create',
                'edit',
                'delete',
                'admin',
            ])
            ->orderBy('action_id', 'ASC')
            ->findAll();
    }
}
