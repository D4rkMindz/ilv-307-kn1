<?php

namespace App\Service\Task;

use App\Service\AppService;
use App\Table\TaskTable;
use App\Table\UserTable;

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
        $validationContext = $taskValidation->validateAddTask($data);
        if (!$validationContext->success()) {
            return ['status' => 'error', 'message' => $validationContext->toArray()];
        }

        if (!$this->hasPermission($data['access_token'], USER)) {
            return ['status' => 'error', 'message' => 'ACTION_NOT_ALLOWED'];
        }

        $taskRow = $this->mapTaskInsertRow($data);
        $taskTable = new TaskTable();
        $taskId = $taskTable->insert($taskRow);

        return ['status' => 'success', 'task_id' => $taskId, 'action' => 'create'];
    }

    /**
     * Update task.
     *
     * @param array $data
     * @param int $userId
     * @param int $taskId
     * @return array
     */
    public function updateTask(array $data, int $userId, int $taskId): array
    {
        $taskValidation = new TaskValidation();
        $validationContext = $taskValidation->validateUpdateTask($data);

        if (!$validationContext->success()) {
            return ['status' => 'error', 'message' => $validationContext->toArray()];
        }

        if (!$this->hasPermission($data['access_token'], USER_PLUS)) {
            return ['status' => 'error', 'message' => 'ACTION_NOT_ALLOWED'];
        }

        $taskUpdateRow = $this->mapTaskUpdateRow($data);
        $taskTable = new TaskTable();
        $taskTable->updateTaskRow($taskUpdateRow, $taskId, $userId);

        return ['status' => 'success', 'task_id' => $taskId, 'action' => 'update'];
    }

    /**
     * Delete Task.
     *
     * @param int $taskId
     * @param string $accessToken
     * @return array
     */
    public function deleteTask(int $taskId, string $accessToken): array
    {
        $executor = $this->getUser($accessToken);

        if (!$this->hasPermission($accessToken, ADMIN)){
            return ['status' => 'error', 'message' => 'ACTION_NOT_ALLOWED'];
        }

        $taskTable = new TaskTable();

        $taskTable->deleteTask($taskId, $executor['id']);

        return ['status' => 'success', 'task_id' => $taskId, 'action' => 'delete'];
    }

    /**
     * Assign task to user.
     *
     * @param int $userId
     * @param int $taskId
     * @param string $accessToken
     * @return array
     */
    public function allocateTaskTo(int $userId, int $taskId, string $accessToken)
    {
        $userTable = new UserTable();
        if (!$userTable->existsId($userId)){
            return ['status'=>'error','error'=>'NONEXISTENT_USER'];
        }

        $taskTable = new TaskTable();
        if (!$taskTable->existsTask($taskId)){
            return ['status'=>'error', 'error'=> 'NONEXISTENT_TASK'];
        }

        if (!$this->hasPermission($accessToken, USER_PLUS)) {
            return ['status' => 'error', 'message' => 'ACTION_NOT_ALLOWED'];
        }
        $taskTable = new TaskTable();
        $taskData = $taskTable->getTask($taskId);
        $assignRow = $this->mapTaskAssignRow($taskData, $accessToken, $userId);
        $newTaskId = $taskTable->insert($assignRow);

        return ['status' => 'success', 'task_id' => $newTaskId, 'action' => 'allocate'];
    }

    /**
     * Deallocate task from user.
     *
     * @param int $userId
     * @param int $taskId
     * @param string $accessToken
     * @return array
     */
    public function deallocateTask(int $userId, int $taskId, string $accessToken): array
    {
        $taskTable = new TaskTable();
        if (!$taskTable->existsTaskForUser($userId, $taskId)) {
            return ['status' => 'error', 'message' => 'TASK_NOT_ALLOCATED'];
        }

        if (!$this->hasPermission($accessToken, ADMIN)) {
            return ['status' => 'error', 'message' => 'ACTION_NOT_ALLOWED'];
        }

        $executor = $this->getUser($accessToken);
        $taskTable->deleteTask($taskId, $executor['id']);

        return ['status' => 'success', 'task_id' => $taskId, 'action' => 'deallocate'];
    }

    /**
     * Map Task insert row.
     *
     * @param array $data
     * @return array
     */
    protected function mapTaskInsertRow(array $data): array
    {
        $executor = $this->getUser($data['access_token']);

        return [
            'user_id' => $data['userId'],
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['dueDate'],
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $executor['id'],
        ];
    }

    /**
     * Map Task update row.
     *
     * @param array $data
     * @return array
     */
    protected function mapTaskUpdateRow(array $data): array
    {
        $user = $this->getUser($data['access_token']);
        $updateRow = [
            'modified' => date('Y-m-d H:i:s'),
            'modified_by' => $user['id'],
        ];

        if (array_key_exists('title', $data)) {
            $updateRow['title'] = $data['title'];
        }

        if (array_key_exists('description', $data)) {
            $updateRow['description'] = $data['description'];
        }

        if (array_key_exists('dueDate', $data)) {
            $updateRow['due_date'] = $data['dueDate'];
        }

        return $updateRow;
    }

    /**
     * Map task assign to user row.
     *
     * @param array $data
     * @param string $accessToken
     * @param int $userId
     * @return array
     */
    protected function mapTaskAssignRow(array $data, string $accessToken, int $userId): array
    {
        $user = $this->getUser($accessToken);
        $assignRow = [
            'user_id' => $userId,
            'title' => $data['title'],
            'description' => $data['description'],
            'due_date' => $data['due_date'],
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $user['id'],
        ];

        return $assignRow;
    }
}
