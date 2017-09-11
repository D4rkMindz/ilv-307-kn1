<?php

namespace App\Table;

/**
 * Class TaskTable
 */
class TaskTable extends AppTable
{
    protected $table = 'tasks';

    public function getTask(int $taskId):array
    {
        $query = $this->newSelect();
        $query->select('*')->where(['id'=> $taskId, 'deleted'=> false]);
        $row = $query->execute()->fetch('assoc');
        return $row;
    }

    /**
     * Check if task exists.
     *
     * @param string $taskId - ID of the task
     * @return bool true if task exists
     */
    public function existsTask(string $taskId): bool
    {
        $query = $this->newSelect();
        $query->select(['id', 'deleted'])->where(['id' => $taskId, 'deleted'=> false]);
        $row = $query->execute()->fetch();
        if ($row['deleted']){
            $row = [];
        }

        return !empty($row);
    }
}
