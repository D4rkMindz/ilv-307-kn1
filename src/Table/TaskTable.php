<?php

namespace App\Table;

/**
 * Class TaskTable
 */
class TaskTable extends AppTable
{
    protected $table = 'tasks';

    /**
     * get Task by id.
     *
     * @param int $taskId
     * @return array
     */
    public function getTask(int $taskId): array
    {
        $query = $this->newSelect();
        $query->select('*')->where(['id' => $taskId, 'deleted' => false]);
        $row = $query->execute()->fetch('assoc');

        return $row;
    }

    /**
     * Get all tasks.
     *
     * @param int $userId
     * @return array
     */
    public function getAllTasks(int $userId): array
    {
        $query = $this->newSelect();
        $query->select('*')->where(['user_id' => $userId, 'deleted' => false]);
        $rows = $query->execute()->fetchAll('assoc');

        return $rows;
    }

    /**
     * Check if a task exists.
     *
     * @param string $taskId - ID of the task
     * @return bool true if task exists
     */
    public function existsTask(string $taskId): bool
    {
        $query = $this->newSelect();
        $query->select('id')->where(['id' => $taskId, 'deleted' => false]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }

    /**
     * Check if a task exists by title.
     *
     * @param string $title - title of a task
     * @return bool tre if task exists
     */
    public function existsTaskByTile(string $title): bool
    {
        $query = $this->newSelect();
        $query->select('id')->where(['title' => $title, 'deleted' => false]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }

    /**
     * Check if task is allocated to user.
     *
     * @param int $userId
     * @param int $taskId
     * @return bool
     */
    public function existsTaskForUser(int $userId, int $taskId): bool
    {
        $query = $this->newSelect();
        $query->select('id')->where(['id' => $taskId, 'userId' => $userId, 'deleted' => false]);
        $row = $query->execute()->fetch();

        return !empty($row);
    }

    /**
     * Delete Task
     *
     * @param int $taskId - task to delete
     * @param int $executorId - ID of the executing user
     * @return bool
     */
    public function deleteTask(int $taskId, int $executorId): bool
    {
        $row = [
            'deleted' => true,
            'deleted_at' => date('Y-m-d H:m:s'),
            'deleted_by' => $executorId,
        ];
        $query = $this->db->newQuery();
        $query->update($this->table)
            ->set($row)
            ->where(['id' => $taskId]);

        return (bool)$query->execute();
    }

    /**
     * Update task row by user_id and task_id.
     *
     * @param array $row - data to update
     * @param int $taskId - task ID
     * @param int $userId - user ID
     * @return bool true if successful
     */
    public function updateTaskRow(array $row, int $taskId, int $userId): bool
    {
        $query = $this->db->newQuery();
        $query->update($this->table)
            ->set($row)
            ->where(['task_id' => $taskId, 'user_id' => $userId]);

        return (bool) $query->execute();
    }
}
