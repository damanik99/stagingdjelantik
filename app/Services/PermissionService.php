<?php

namespace App\Services;

class PermissionService
{
    protected $db;

    public function __construct()
    {
        $this->db = db_connect();
    }

    /**
     * Check apakah user memiliki privilege
     * untuk page + action pada program aktif.
     */
    public function can(
        int $usersId,
        int $pageId,
        int $actionId
    ): bool {

        $programId = session()->get('program');

        if (
            $usersId <= 0 ||
            $programId <= 0 ||
            $pageId <= 0 ||
            $actionId <= 0
        ) {
            return false;
        }

        $builder = $this->db->table('usersgroupprogram ugp');

        $builder->select([
            'ugp.group_id',
            'g.name AS group_name',
            'pr.privilege_id',
        ]);

        $builder->join(
            '`group` g',
            'g.group_id = ugp.group_id',
            'INNER'
        );

        $builder->join(
            'privilege pr',
            'pr.group_id = ugp.group_id
         AND pr.page_id = ' . $this->db->escape($pageId) . '
         AND pr.action_id = ' . $this->db->escape($actionId),
            'LEFT'
        );

        $builder->where('ugp.users_id', $usersId);
        $builder->where('ugp.program_id', $programId);

        $builder->limit(1);

        $result = $builder->get()->getFirstRow();

        if (!$result) {
            return false;
        }

        /*
     * Administrator = unrestricted access
     */
        if (
            strtoupper(trim($result->group_name)) === 'ADMINISTRATOR'
        ) {
            return true;
        }

        /*
     * Normal group:
     * harus memiliki privilege.
     */
        return !empty($result->privilege_id);
    }
}
