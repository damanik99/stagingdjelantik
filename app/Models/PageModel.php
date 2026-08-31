<?php

namespace App\Models;

use CodeIgniter\Model;

class PageModel extends Model
{
    protected $table      = 'page';
    protected $primaryKey = 'page_id';

    protected $allowedFields = ['name', 'created_date', 'modified_date', 'created_by', 'modified_by'];

    public function getAllPages(): array
    {
        return $this->orderBy('name', 'ASC')->findAll();
    }
}
