<?php

use Config\Database;

if (!function_exists('can')) {
    /**
     * Cek apakah user memiliki akses untuk melakukan action tertentu pada page tertentu
     *
     * @param string $action
     * @param string $page
     * @return bool
     */
    function can(string $action, string $page): bool
    {
        $session = session();
        $userId = (int) ($session->get('users_id') ?? 0);

        if ($userId <= 0) {
            return false;
        }

        // Ambil program_id dari session atau gunakan program pertama user
        $programId = $session->get('program_id');
        if (empty($programId)) {
            // Ambil program_id pertama yang user miliki
            $db = Database::connect();
            $programId = $db->table('usersgroupprogram')
                            ->select('program_id')
                            ->where('users_id', $userId)
                            ->limit(1)
                            ->get()
                            ->getFirstRow()
                            ->program_id;
            $session->set('program_id', $programId);
        }

        // Cek action_id
        $db = Database::connect();
        $actionId = $db->table('action')
                       ->select('action_id')
                       ->where('LOWER(name)', strtolower($action))
                       ->limit(1)
                       ->get()
                       ->getFirstRow()
                       ->action_id;

        if ($actionId === null) {
            return false;
        }

        // Cari page_id berdasarkan page yang diberikan
        $pageId = $db->table('page')
                     ->select('page_id')
                     ->where('LOWER(name)', strtolower($page)) // Ganti sesuai kebutuhan
                     ->limit(1)
                     ->get()
                     ->getFirstRow()
                     ->page_id;

        if ($pageId === null) {
            return false;
        }

        // Ambil group_id user yang terdaftar di program_id
        $groupIds = $db->table('usersgroupprogram')
                       ->select('group_id')
                       ->where('users_id', $userId)
                       ->where('program_id', $programId)
                       ->get()
                       ->getResult();

        if (empty($groupIds)) {
            return false;
        }

        $groupIds = array_map(fn ($r) => (int)$r->group_id, $groupIds);

        // Cek apakah user memiliki privilege untuk page_id dan action_id tertentu
        $privilegeCount = $db->table('privilege')
                             ->select('COUNT(1) AS cnt')
                             ->where('page_id', $pageId)
                             ->where('action_id', $actionId)
                             ->whereIn('group_id', $groupIds)
                             ->get()
                             ->getFirstRow()
                             ->cnt;

        return (int)$privilegeCount > 0;
    }
}
