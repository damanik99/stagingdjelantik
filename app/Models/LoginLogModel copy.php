<?php
namespace App\Models;
use CodeIgniter\Model;
 
class LoginLogModel extends Model
{
    protected $table      = 'loginlog';
    protected $primaryKey = 'login_log_id';

    protected $allowedFields = ['users_id', 'ip', 'browser', 'utm', 'created_date', 'modified_date', 'created_by', 'modified_by'];

}