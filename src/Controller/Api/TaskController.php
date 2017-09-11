<?php

namespace App\Controller\Api;

use App\Service\Task\TaskService;
use App\Table\TaskTable;
use App\Table\UserTaskTable;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class TaskController
 */
class TaskController extends ApiController
{
    /**
     * Get all tasks.
     *
     * @return JsonResponse
     */
    public function getTasks()
    {
        $userId = (int)$this->request->attributes->get('user_id');
        $userTaskTable = new UserTaskTable();
        $tasks = $userTaskTable->findAllTasks($userId);

        return $this->json($tasks);
    }

    /**
     * Get one task by id.
     *
     * @return JsonResponse
     */
    public function getTask()
    {
        $taskId = (int)$this->request->attributes->get('task_id');
        $userTaskTable = new TaskTable();
        $task = $userTaskTable->getTask($taskId);

        return $this->json($task);
    }

    /**
     * Create task.
     *
     * Required array keys:
     *
     * string   access_token
     * string   title
     * string   description
     * datetime dueDate (Y-m-d H:i:s)
     *
     * @return JsonResponse
     */
    public function createTask()
    {
        $data = $this->getJsonRequest(request());
        $taskService = new TaskService();
        $response = $taskService->addTask($data);

        return $this->json($response);
    }

    /**
     * Update task.
     *
     * @return JsonResponse
     */
    public function updateTask()
    {
        //TODO
        return $this->json([]);
    }

    /**
     * Delete Task
     *
     * @return JsonResponse
     */
    public function deleteTask()
    {
        $taskId = (int)$this->request->attributes->get('task_id');
        $taskTable = new TaskTable();
        $taskTable->delete($taskId);

        return $this->json(['status' => 'success', 'deleted_task_id' => $taskId]);
    }
}
