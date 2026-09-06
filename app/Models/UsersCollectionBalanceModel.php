<?php
namespace App\Models;
use CodeIgniter\Model;
class UsersCollectionBalanceModel extends Model { protected $table='users_collection_balance'; protected $primaryKey='users_id'; protected $useAutoIncrement=false; protected $returnType='array'; protected $allowedFields=['users_id','total_qty','total_visit','last_visit_date','last_visit_time','modified_date']; }
