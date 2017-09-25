<?php

namespace App\Table;

/**
 * Class UserTable
 */
class UserTable extends AppTable
{
    protected $table = 'users';

    /**
     * Get all with joined values.
     *
     * @param $page
     * @param $limit
     * @return array
     */
    public function getAllJoined($page, $limit)
    {
        $lang = substr(session()->get('lang'), 0, 2);
        if (!$lang){
            $lang = 'en';
        }
        $fields = [
            $this->table . '.id',
            $this->table . '.person_id',
            $this->table . '.role_id',
            $this->table . '.oauth_clients_id',
            $this->table . '.username',
            $this->table . '.created',
            $this->table . '.created_by',
            $this->table . '.modified',
            $this->table . '.modified_by',
            $this->table . '.deleted',
            $this->table . '.deleted_at',
            $this->table . '.deleted_by',
            'role_title' => 'r.title',
            'role_level' => 'r.level',
            'first_name' => 'p.first_name',
            'last_name' => 'p.last_name',
            'address' => 'p.address',
            'postcode' => 'pc.number',
            'city' => 'pc.title_' . $lang,
            'created_by_name' => 't.username',
            'modified_by_name' => 'm.username',
            'deleted_by_name' => 'd.username',
        ];
        $query = $this->newSelect();
        $query->select($fields)
            ->join([
                't' => [
                    'table' => $this->table,
                    'type' => 'LEFT',
                    'conditions' => 't.id = ' . $this->table . '.created_by',
                ],
                'm' => [
                    'table' => $this->table,
                    'type' => 'LEFT',
                    'conditions' => 'm.id = ' . $this->table . '.modified_by',
                ],
                'd' => [
                    'table' => $this->table,
                    'type' => 'LEFT',
                    'conditions' => 'd.id = ' . $this->table . '.deleted_by',
                ],
                'r' => [
                    'table' => 'roles',
                    'type' => 'INNER',
                    'conditions' => 'r.id = ' . $this->table . '.role_id',
                ],
                'p' => [
                    'table' => 'people',
                    'type' => 'INNER',
                    'conditions' => 'p.id = ' . $this->table . '.person_id',
                ],
                'pc' => [
                    'table' => 'postcodes',
                    'type' => 'INNER',
                    'conditions' => 'pc.id = p.postcode_id',
                ],
            ])
        ->page($page, $limit);
        $rows = $query->execute()->fetchAll('assoc');

        return $rows;
    }

    /**
     * Check if username exists.
     *
     * @param string $username - with username
     * @return bool true if username exists
     */
    public function existsUsername(string $username): bool
    {
        $query = $this->newSelect();
        $query->select(['username', 'deleted'])->where(['username' => $username, 'deleted' => false]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }

    /**
     * Check if ID exists
     *
     * @param int $id - user ID
     * @return bool true if ID exists
     */
    public function existsId(int $id): bool
    {
        $query = $this->newSelect();
        $query->select(['id', 'deleted'])->where(['id' => $id, 'deleted' => false]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }

    /**
     * Get user by ID.
     *
     * @param int $userId - user ID
     * @return array $row - single user entity
     */
    public function getUserById(int $userId): array
    {
        $lang = substr(session()->get('lang'), 0, 2);
        if (!$lang){
            $lang = 'en';
        }
        $fields = [
            $this->table . '.id',
            $this->table . '.person_id',
            $this->table . '.role_id',
            $this->table . '.oauth_clients_id',
            $this->table . '.username',
            $this->table . '.created',
            $this->table . '.created_by',
            $this->table . '.modified',
            $this->table . '.modified_by',
            $this->table . '.deleted',
            $this->table . '.deleted_at',
            $this->table . '.deleted_by',
            'role_title' => 'r.title',
            'role_level' => 'r.level',
            'first_name' => 'p.first_name',
            'last_name' => 'p.last_name',
            'address' => 'p.address',
            'postcode' => 'pc.number',
            'city' => 'pc.title_' . $lang,
            'created_by_name' => 't.username',
            'modified_by_name' => 'm.username',
            'deleted_by_name' => 'd.username',
        ];
        $query = $this->newSelect();
        $query->select($fields)
            ->join([
                't' => [
                    'table' => $this->table,
                    'type' => 'LEFT',
                    'conditions' => 't.id = ' . $this->table . '.created_by',
                ],
                'm' => [
                    'table' => $this->table,
                    'type' => 'LEFT',
                    'conditions' => 'm.id = ' . $this->table . '.modified_by',
                ],
                'd' => [
                    'table' => $this->table,
                    'type' => 'LEFT',
                    'conditions' => 'd.id = ' . $this->table . '.deleted_by',
                ],
                'r' => [
                    'table' => 'roles',
                    'type' => 'INNER',
                    'conditions' => 'r.id = ' . $this->table . '.role_id',
                ],
                'p' => [
                    'table' => 'people',
                    'type' => 'INNER',
                    'conditions' => 'p.id = ' . $this->table . '.person_id',
                ],
                'pc' => [
                    'table' => 'postcodes',
                    'type' => 'INNER',
                    'conditions' => 'pc.id = p.postcode_id',
                ],
            ])
            ->where(['users.id' => $userId])
            ->limit(1);
        $row = $query->execute()->fetch('assoc');

        if (!$row) {
            return [];
        }

        return $row;
    }

    /**
     * Delete user.
     *
     * @param int $userId
     * @param int $executorId
     * @return bool
     */
    public function deleteUser(int $userId, int $executorId): bool
    {
        $row = [
            'deleted' => true,
            'deleted_at' => date('Y-m-d H:m:s'),
            'deleted_by' => $executorId,
        ];
        $query = $this->db->newQuery();
        $query->update($this->table)
            ->set($row)
            ->where(['id' => $userId]);

        return (bool)$query->execute();
    }
}
