<?php
namespace App\Models;
use CodeIgniter\Model;
class UsersCollectionDailySummaryModel extends Model { protected $table='users_collection_daily_summary'; protected $primaryKey='users_collection_daily_summary_id'; protected $returnType='array'; protected $allowedFields=['users_id','summary_date','total_qty','total_visit','created_date','modified_date']; }
