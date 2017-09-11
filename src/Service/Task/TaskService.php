<?php

namespace App\Service\Task;

use App\Service\AppService;
use App\Table\TaskTable;

/**
 * Class TaskService
 */
class TaskService extends AppService
{
    /**
     * Add new Task.
     *
     * Required array keys:
     *
     * string   access_token
     * string   title
     * string   description
     * datetime dueDate (Y-m-d H:i:s)
     *
     * @param array $data
     * @return array
     */
    public function addTask(array $data): array
    {
        $taskValidation = new TaskValidation();
        $validationContext = $taskValidation->validate($data);
        if (!$validationContext->success()) {
            return $validationContext->toArray();
        }

        if (!$this->hasPermission($data['access_token'], USER)) {
            return ['status' => 'error', 'error' => 'ACTION_NOT_ALLOWED'];
        }

        $taskRow = $this->mapTaskRow($data);
        $taskTable = new TaskTable();
        $taskId = $taskTable->insert($taskRow);

        return ['status' => 'success', 'task_id' => $taskId];
    }

    /**
     * Map Task row.
     *
     * @param array $data
     * @return array
     */
    protected function mapTaskRow(array $data): array
    {
        $user = $this->getUser($data['access_token']);

        return [
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['dueDate'],
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $user['id'],
        ];
    }
}
