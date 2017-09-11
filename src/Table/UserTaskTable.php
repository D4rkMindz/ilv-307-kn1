<?php

namespace App\Table;

use Cake\Database\StatementInterface;

class UserTaskTable extends AppTable
{
    protected $table = 'user_tasks';

    /**
     * Check if task is assigned to user.
     *
     * @param int $userId - user ID
     * @param int $taskId - task ID
     * @return bool true if task is already assigned
     */
    public function isTaskAllocated(int $userId, int $taskId): bool
    {
        $query = $this->newSelect();
        $query->select('id')->where(['user_id' => $userId, 'task_id' => $taskId]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }

    /**
     * Find all tasks for user.
     *
     * @param int $userId - user ID
     * @return array $rows - user tasks
     */
    public function findAllTasks(int $userId): array
    {
        $fields = [
            't.id',
            't.title',
            't.description',
            't.due_date',
        ];
        $query = $this->newSelect();
        $query->select($fields)->join([
            't' => [
                'table' => 'tasks',
                'type' => 'INNER',
                'conditions' => 't.id = ' . $this->table . '.task_id',
            ],
        ])->where([$this->table . '.user_id' => $userId]);
        $rows = $query->execute()->fetchAll('assoc');

        return !empty($rows) ? $rows : [];
    }

    /**
     * Get user task id.
     *
     * @param int $userId - user ID
     * @param int $taskId - task ID
     * @return int
     */
    public function getUserTaskId(int $userId, int $taskId): int
    {
        $query = $this->newSelect();
        $query->select('id')->where(['user_id' => $userId, 'task_id' => $taskId]);
        $row = $query->execute()->fetch();

        return !empty($row) ? $row[0] : 0;
    }

    /**
     * Delete UserTask
     *
     * @param int $userId - user ID
     * @param int $taskId - task ID
     * @return StatementInterface
     */
    public function deleteUserTask(int $userId, int $taskId): StatementInterface
    {
        return $this->db->delete($this->table, ['user_id' => $userId, 'task_id' => $taskId]);
    }
}
