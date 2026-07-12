<?php namespace App\Models;

use CodeIgniter\Model;

class NotificationModel extends Model
{
    protected $table      = 'notification';
    protected $primaryKey = 'notification_id';

    protected $allowedFields = ['program_id', 'timeline_id', 'users_id', 'type', 'name', 'description', 'active', 'read', 'created_date', 'modified_date', 'created_by', 'modified_by'];

}