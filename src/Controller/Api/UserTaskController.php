<?php

namespace App\Controller\Api;

use App\Table\TaskTable;
use App\Table\UserTable;
use App\Table\UserTaskTable;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserTaskController
 */
class UserTaskController extends ApiController
{
    /**
     * Allocate a task to a user.
     *
     * @return JsonResponse
     */
    public function allocate(): JsonResponse
    {
        $userId = (int)$this->request->attributes->get('user_id');
        $taskId = (int)$this->request->attributes->get('task_id');

        $userTable = new UserTable();
        if (!$userTable->existsId($userId)){
            return $this->json(['status'=>'error','error'=>'NONEXISTENT_USER']);
        }

        $taskTable = new TaskTable();
        if (!$taskTable->existsTask($taskId)){
            return $this->json(['status'=>'error', 'error'=> 'NONEXISTENT_TASK']);
        }

        $userTaskTable = new UserTaskTable();
        if ($userTaskTable->isTaskAllocated($userId, $taskId)) {
            return $this->json(['status' => 'error', 'error' => 'TASK_ALREADY_ALLOCATED']);
        }

        $userTaskRow = [
            'user_id' => $userId,
            'task_id' => $taskId,
        ];
        $id = $userTaskTable->insert($userTaskRow);

        return $this->json(['status' => 'success', 'user_task_id' => $id]);
    }

    /**
     * Deallocate a user and a task.
     *
     * @return JsonResponse
     */
    public function deallocate()
    {
        $userId = (int)$this->request->attributes->get('user_id');
        $taskId = (int)$this->request->attributes->get('task_id');
        $userTaskTable = new UserTaskTable();
        if (!$userTaskTable->isTaskAllocated($userId, $taskId)) {
            return $this->json(['status' => 'error', 'error' => 'TASK_NOT_ALLOCATED']);
        }

        $id = $userTaskTable->getUserTaskId($userId, $taskId);
        $userTaskTable->deleteUserTask($userId, $taskId);

        return $this->json(['status' => 'success', 'deleted_user_task_id' => $id]);
    }
}
