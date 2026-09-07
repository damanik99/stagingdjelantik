<?php
namespace App\Models;
use CodeIgniter\Model;
class UsersCollectionMonthlySummaryModel extends Model { protected $table='users_collection_monthly_summary'; protected $primaryKey='users_collection_monthly_summary_id'; protected $returnType='array'; protected $allowedFields=['users_id','summary_year','summary_month','total_qty','total_visit','created_date','modified_date']; }
