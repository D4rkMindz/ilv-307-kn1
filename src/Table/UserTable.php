<?php

namespace App\Table;

/**
 * Class UserTable
 */
class UserTable extends AppTable
{
    protected $table = 'users';

    /**
     * Check if username exists.
     *
     * @param string $username - with username
     * @return bool true if username exists
     */
    public function existsUsername(string $username): bool
    {
        $query = $this->newSelect();
        $query->select(['username', 'deleted'])->where(['username' => $username, 'deleted'=> false]);
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
        $query->select(['id', 'deleted'])->where(['id' => $id, 'deleted'=> false]);
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
        $fields = [
            'users.username',
            'roles.level',
            'roles.title',
            'people.first_name',
            'people.last_name',
            'address' => 'people.address',
            'postcode' => 'postcodes.number',
        ];
        $query = $this->newSelect();
        $query->select($fields)
            ->join([
                'roles' => [
                    'table' => 'roles',
                    'type' => 'INNER',
                    'conditions' => 'roles.id = users.role_id',
                ],
                'people' => [
                    'table' => 'people',
                    'type' => 'INNER',
                    'conditions' => 'people.id = users.person_id',
                ],
                'postcodes' => [
                    'table' => 'postcodes',
                    'type' => 'INNER',
                    'conditions' => 'postcodes.id = people.postcode_id',
                ],
            ])
            ->where(['users.id' => $userId, 'users.deleted'=> false])
            ->limit(1);
        $row = $query->execute()->fetch();

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
