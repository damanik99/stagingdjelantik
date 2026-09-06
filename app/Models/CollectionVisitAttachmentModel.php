<?php

namespace App\Models;

use CodeIgniter\Model;

class CollectionVisitAttachmentModel extends Model
{
    protected $table = 'collection_visit_attachment';
    protected $primaryKey = 'collection_visit_attachment_id';
    protected $returnType = 'array';
    protected $allowedFields = [
        'collection_visit_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
        'created_date',
        'created_by',
    ];
}
