<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\RequestInterface;

class DashboardModel extends Model
{
    protected $request;
    protected $db;

    public function newsfeed($limit, $start)
    {
        $db = \Config\Database::connect();
        $program_id = session()->get('program');

        $builders = $db->table('timeline');
        $builders->select('timeline_id, username, `type`, location, timeline.created_date, description');
        $builders->join('users', 'timeline.users_id = users.users_id');
        $builders->orderBy('timeline.created_date', 'DESC');
        $builders->orderBy('timeline_id', 'DESC');
        $builders->where('program_id', $program_id);
        $builders->limit("1000");

        return $builders;
    }

    public function setsummary()
    {
        $users_id = session()->get('users_id');
        $program_id = session()->get('program');

        $builders = $this->db->table('setsummary');
        $builders->select('*');
        $builders->where('users_id', $users_id);
        $builders->where('program_id', $program_id);

        return $builders->get()->getRow();
    }

    public function allSummaryAtt($users_id = false, $start_date = false, $finish_date = false)
    {
        $loggedUserId = session()->get('users_id');
        $program_id = session()->get('program');

        if (empty($start_date)) {
            $start_date = date('Y-m-d', strtotime('-30 days'));
        }
        if (empty($finish_date)) {
            $finish_date = date('Y-m-d');
        }

        $dataUser = $this->db->table('usersgroupprogram')
            ->select('*')
            ->where('users_id', $loggedUserId)
            ->get()
            ->getRow();

        $level = $dataUser->data_level;

        $builder = $this->db->table('attendance');
        $builder->select('COUNT(attendance_id) AS att, 
            "' .$start_date.'" AS tanggal_awal, 
            "'.$finish_date .'" AS tanggal_akhir');
        $builder->join('users', 'attendance.users_id = users.users_id');
        $builder->where('attendance.program_id', $program_id);

        // Jika level tinggi, bisa pilih user lain
        if ($level == 'high') {
            if ($users_id) {
                $builder->where('attendance.users_id', $users_id);
            }
        } else {
            // Level bukan tinggi, hanya bisa lihat dirinya sendiri
            $builder->where('attendance.users_id', $loggedUserId);
        }

        // Filter tanggal jika ada
        if (!empty($start_date) && !empty($finish_date)) {
            $builder->where('DATE(attendance.created_date) >=', $start_date);
            $builder->where('DATE(attendance.created_date) <=', $finish_date);
        } else {
            // Filter 30 hari terakhir
            $builder->where('DATE(attendance.created_date) >=', date('Y-m-d', strtotime('-30 days')));
        }

        return $builder->get()->getRow();
    }

    public function allSummaryAct()
    {
        $db = \Config\Database::connect();
        $program_id = session()->get('program');

        $builders = $db->table('activity');
        $builders->select('COUNT(activity_id) AS act');
        $builders->where('DATE(datetime)', 'DATE(NOW())');
        $builders->where('program_id', $program_id);

        return $builders->get()->getRow();

    }

    public function allSummaryDst($users_id = false, $start_date = false, $finish_date = false)
    {

        $loggedUserId = session()->get('users_id');
        $program_id = session()->get('program');

        if (empty($start_date)) {
            $start_date = date('Y-m-d', strtotime('-30 days'));
        }
        if (empty($finish_date)) {
            $finish_date = date('Y-m-d');
        }

        $dataUser = $this->db->table('usersgroupprogram')
        ->select('*')
        ->where('users_id', $loggedUserId)
        ->get()
        ->getRow();

        $level = $dataUser->data_level;

        $builder = $this->db->table('merchandisedistribution');
        $builder->select('COUNT(merchandise_distribution_id) AS dst, 
                        "' . $start_date . '" AS tanggal_awal,
                        "' . $finish_date . '" AS tanggal_akhir');
        $builder->join('programitem', 'merchandisedistribution.program_item_id = programitem.program_item_id');
        $builder->join('usersorganization', 'merchandisedistribution.users_organization_id = usersorganization.users_organization_id');
        $builder->where('programitem.program_id', $program_id);

        // Jika level tinggi, bisa pilih user lain
        if ($level == 'high') {
            if ($users_id) {
                $builder->where('usersorganization.users_id', $users_id);
            }
        } else {
            // Level bukan tinggi, hanya bisa lihat dirinya sendiri
            $builder->where('usersorganization.users_id', $loggedUserId);
        }

        // Filter tanggal jika ada
        if ($start_date && $finish_date) {
            $builder->where('DATE(merchandisedistribution.created_date) >=', $start_date);
            $builder->where('DATE(merchandisedistribution.created_date) <=', $finish_date);
        } else {
            // Default 30 hari terakhir
            $builder->where('DATE(merchandisedistribution.created_date) >=', date('Y-m-d', strtotime('-30 days')));
        }

        return $builder->get()->getRow();
    }

    public function regionAttVisit()
    {
        $program_id = session()->get('program');
        $startDate = date('Y-m-01'); // Hari pertama bulan ini
        $finishDate = date('Y-m-d'); // Hari ini

        // Membuat query untuk mendapatkan data per region
        $builder = $this->db->table('attendance a')
        ->select('region, COUNT(*) AS total_visits, 
                COUNT(DISTINCT c.users_id) AS total_users, 
                "' . $startDate . '" AS startDate, 
                "' . $finishDate . '" AS endDate')
        ->join('attendancetype b', 'a.attendance_type_id = b.attendance_type_id')
        ->join('users c', 'a.users_id = c.users_id')
        ->where('a.program_id', $program_id)
        ->where('b.name', 'visit')
        ->groupBy('region');

        // Filter tanggal
        if ($startDate && $finishDate) {
            $builder->where('DATE(a.created_date) >=', $startDate);
            $builder->where('DATE(a.created_date) <=', $finishDate);
        } else {
            // Default 30 hari terakhir
            $builder->where('DATE(a.created_date) >=', date('Y-m-d', strtotime('-30 days')));
        }

        return $builder->get()->getResultArray();
    }

    public function allSummarySll($users_id = false, $start_date = false, $finish_date = false)
    {
        $loggedUserId = session()->get('users_id');
        $program_id = session()->get('program');

        if (empty($start_date)) {
            $start_date = date('Y-m-d', strtotime('-30 days'));
        }
        if (empty($finish_date)) {
            $finish_date = date('Y-m-d');
        }

        $dataUser = $this->db->table('usersgroupprogram')
        ->select('*')
        ->where('users_id', $loggedUserId)
        ->get()
        ->getRow();

        $level = $dataUser->data_level;

        $builder = $this->db->table('selling');
        $builder->select('SUM(programitem.market_price) AS sll,
                        "' . $start_date . '" AS tanggal_awal,
                        "' . $finish_date . '" AS tanggal_akhir');
        $builder->join('programitem', 'selling.program_item_id = programitem.program_item_id');
        $builder->join('usersorganization', 'selling.users_organization_id = usersorganization.users_organization_id');
        $builder->where('programitem.program_id', $program_id);

        // Jika level tinggi, bisa pilih user lain
        if ($level == 'high') {
            if ($users_id) {
                $builder->where('usersorganization.users_id', $users_id);
            }
        } else {
            // Level bukan tinggi, hanya bisa lihat dirinya sendiri
            $builder->where('usersorganization.users_id', $loggedUserId);
        }
        // echo var_dump($builder);exit;
        // Filter tanggal jika ada
        if ($start_date && $finish_date) {
            $builder->where('DATE(selling.selling_date) >=', $start_date);
            $builder->where('DATE(selling.selling_date) <=', $finish_date);
        } else {
            // Default 30 hari terakhir
            $builder->where('DATE(selling.selling_date) >=', date('Y-m-d', strtotime('-30 days')));
        }

        return $builder->get()->getRow();

    }

    public function databestSell($start_date = false, $finish_date = false)
    {
        $loggedUserId = session()->get('users_id');
        $program_id = session()->get('program');

        if (empty($start_date)) {
            $start_date = date('Y-m-01');
        }
        if (empty($finish_date)) {
            $finish_date = date('Y-m-d');
        }

        $dataUser = $this->db->table('usersgroupprogram')
        ->select('*')
        ->where('users_id', $loggedUserId)
        ->get()
        ->getRow();

        $level = $dataUser->data_level;
        //  echo var_dump($start_date);exit;
        $builder = $this->db->table('selling');
        $builder->select('selling.selling_id, usersorganization.users_organization_id, selling.quantity, organization.name AS channel, users.users_id, users.username,
        SUM(selling.quantity) AS total_quantity, programitem.program_id,
        "' . $start_date . '" AS tanggal_awal,
        "' . $finish_date . '" AS tanggal_akhir');
        $builder->join('usersorganization', 'selling.users_organization_id = usersorganization.users_organization_id');
        $builder->join('clientorganization', 'usersorganization.client_organization_id = clientorganization.client_organization_id');
        $builder->join('organization', 'clientorganization.organization_id = organization.organization_id');
        $builder->join('users', 'usersorganization.users_id = users.users_id');
        $builder->join('programitem', 'selling.program_item_id = programitem.program_item_id');
        $builder->where('programitem.program_id', $program_id);

        // Filter tanggal jika ada
        if ($start_date && $finish_date) {
            $builder->where('DATE(selling.selling_date) >=', $start_date);
            $builder->where('DATE(selling.selling_date) <=', $finish_date);
        } else {
            // Default 30 hari terakhir
            $builder->where('DATE(selling.selling_date) >=', date('Y-m-d', strtotime('-30 days')));
        }

        $builder->groupBy('users.users_id');
        $builder->orderBy('total_quantity', 'DESC');
        $builder->limit('6');

        return $builder->get()->getResultArray();
    }

    public function databestdst($start_date = false, $finish_date = false)
    {
        $loggedUserId = session()->get('users_id');
        $program_id = session()->get('program');

        if (empty($start_date)) {
            $start_date = date('Y-m-d', strtotime('-30 days'));
        }
        if (empty($finish_date)) {
            $finish_date = date('Y-m-d');
        }

        $dataUser = $this->db->table('usersgroupprogram')
        ->select('*')
        ->where('users_id', $loggedUserId)
        ->get()
        ->getRow();

        $level = $dataUser->data_level;
        //  echo var_dump($start_date);exit;
        $builder = $this->db->table('merchandisedistribution');
        $builder->select('merchandisedistribution.merchandise_distribution_id, usersorganization.users_organization_id, merchandisedistribution.quantity, organization.name AS channel, users.users_id, users.username,
        item.name AS item_name, SUM(merchandisedistribution.display) AS total_quantity, programitem.program_id,
        "' . $start_date . '" AS tanggal_awal,
        "' . $finish_date . '" AS tanggal_akhir');
        $builder->join('usersorganization', 'merchandisedistribution.users_organization_id = usersorganization.users_organization_id');
        $builder->join('clientorganization', 'usersorganization.client_organization_id = clientorganization.client_organization_id');
        $builder->join('organization', 'clientorganization.organization_id = organization.organization_id');
        $builder->join('users', 'usersorganization.users_id = users.users_id');
        $builder->join('programitem', 'merchandisedistribution.program_item_id = programitem.program_item_id');
        $builder->join('item', 'programitem.item_id = item.item_id');
        $builder->where('programitem.program_id', $program_id);

        // Filter tanggal jika ada
        if ($start_date && $finish_date) {
            $builder->where('DATE(merchandisedistribution.distribution_date) >=', $start_date);
            $builder->where('DATE(merchandisedistribution.distribution_date) <=', $finish_date);
        } else {
            // Default 30 hari terakhir
            $builder->where('DATE(merchandisedistribution.distribution_date) >=', date('Y-m-d', strtotime('-30 days')));
        }

        $builder->orderBy('total_quantity', 'DESC');
        $builder->groupBy('users.users_id', $program_id);
        $builder->limit('6');

        return $builder->get()->getResultArray();
    }

    public function dataItem()
    {
        $db = \Config\Database::connect();
        $program_id = session()->get('program');

        $query = $db->table('programitem');
        $query->select('programitem.program_item_id, item.name AS item_name');
        $query->join('item', 'programitem.`item_id` = item.`item_id`');
        $query->where('programitem.program_id', $program_id);

        return $query->get()->getResultArray();

    }

    public function dataAtt($code)
    {
        $db = \Config\Database::connect();
        $users_id = session()->get('users_id');
        $program_id = session()->get('program');

        $query = $db->table('attendance');
        // $query->select('programitem.program_item_id, item.name AS item_name');
        $query->join('users', 'users.`users_id` = attendance.`users_id`');
        $query->where('attendance.program_id', $program_id);
        $query->where('attendance.code', $code);

        return $query->get()->getRow();
    }

    public function getChannel($channel)
    {
        $db = \Config\Database::connect();

        // $channel = ;
        $status_id = $db->table('status')->select('status_id')->like('code', 'UORG_ACTIVE')->get()->getResultArray();

        $users_id = session()->get('users_id');

        $query = $db->table('usersorganization');
        $query->select('usersorganization.users_organization_id, organization.name, usersorganization.users_id');
        $query->join('clientorganization', 'usersorganization.client_organization_id = clientorganization.client_organization_id');
        $query->join('organization', 'clientorganization.organization_id = organization.organization_id');
        // $query->like('organization.name',$channel);
        $query->where('usersorganization.status_id', $status_id[0]['status_id']);
        $query->where('usersorganization.users_organization_id', $channel);
        // users_organization_id
        return $query->get()->getRow();
    }

    public function getTotalUsers()
    {
        $program_id = $program_id = session()->get('program');
        return $this->db->table('usersgroupprogram a')
            ->join('program b', 'a.program_id = b.program_id')
            ->join('users c', 'a.`users_id` = c.`users_id`')
            ->join('`group` d', 'a.`group_id` = d.`group_id`')
            ->where('a.program_id', $program_id)
            ->where('a.data_level', 'low')
            ->where('c.active', '1')
            ->countAllResults();
    }

    // public function getTotalMonthly ()
    // {
    //     return $this->db->table()
    //     ->join()
    // }
}
