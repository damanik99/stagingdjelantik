<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RemoveCollectorFromCollection extends Migration
{
    public function up()
    {
        $db = $this->db;
        $db->query("CREATE TABLE IF NOT EXISTS users_collection_balance (users_id BIGINT UNSIGNED NOT NULL, total_qty DECIMAL(18,3) NOT NULL DEFAULT 0, total_visit BIGINT UNSIGNED NOT NULL DEFAULT 0, last_visit_date DATE NULL, last_visit_time TIME NULL, modified_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (users_id)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $db->query("CREATE TABLE IF NOT EXISTS users_collection_daily_summary (users_collection_daily_summary_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, users_id BIGINT UNSIGNED NOT NULL, summary_date DATE NOT NULL, total_visit BIGINT UNSIGNED NOT NULL DEFAULT 0, total_qty DECIMAL(18,3) NOT NULL DEFAULT 0, created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, modified_date DATETIME NULL ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (users_collection_daily_summary_id), UNIQUE KEY uk_users_collection_daily (users_id, summary_date)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        $db->query("CREATE TABLE IF NOT EXISTS users_collection_monthly_summary (users_collection_monthly_summary_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT, users_id BIGINT UNSIGNED NOT NULL, summary_year SMALLINT UNSIGNED NOT NULL, summary_month TINYINT UNSIGNED NOT NULL, total_visit BIGINT UNSIGNED NOT NULL DEFAULT 0, total_qty DECIMAL(18,3) NOT NULL DEFAULT 0, created_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, modified_date DATETIME NULL ON UPDATE CURRENT_TIMESTAMP, PRIMARY KEY (users_collection_monthly_summary_id), UNIQUE KEY uk_users_collection_monthly (users_id, summary_year, summary_month)) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
        if (!$this->db->fieldExists('users_id', 'collection_visit')) {
            $db->query("ALTER TABLE collection_visit ADD COLUMN users_id BIGINT UNSIGNED NULL AFTER visit_number");
        }
        if (!$this->db->fieldExists('organization_program_id', 'collection_visit')) {
            $db->query("ALTER TABLE collection_visit ADD COLUMN organization_program_id INT NULL AFTER users_id");
        }
        if ($this->db->fieldExists('collector_id', 'collection_visit')) {
            $db->query("UPDATE collection_visit cv JOIN collector c ON c.collector_id=cv.collector_id SET cv.users_id=c.users_id, cv.organization_program_id=c.organization_program_id");
            $db->query("ALTER TABLE collection_visit DROP COLUMN collector_id");
        }
        // Sebagian instalasi sudah memiliki foreign key pada kolom ini;
        // biarkan definisi nullability existing agar migration idempotent.
        $db->query("DROP TABLE IF EXISTS collector_balance");
        $db->query("DROP TABLE IF EXISTS collector_daily_summary, collector_monthly_summary");
        $db->query("DROP TABLE IF EXISTS collector");
    }

    public function down()
    {
        $this->db->query('ALTER TABLE collection_visit ADD COLUMN collector_id BIGINT UNSIGNED NULL AFTER visit_number');
        $this->db->query('ALTER TABLE collection_visit DROP COLUMN users_id, DROP COLUMN organization_program_id');
        $this->db->query('DROP TABLE IF EXISTS users_collection_monthly_summary, users_collection_daily_summary, users_collection_balance');
    }
}
