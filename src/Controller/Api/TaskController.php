<?php

namespace App\Controller\Api;

use App\Service\Task\TaskService;
use App\Table\TaskTable;
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
        $taskTable = new TaskTable();
        $tasks = $taskTable->getAllTasks($userId);

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
        $userTable = new TaskTable();
        $task = $userTable->getTask($taskId);

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
        $data = $this->getJsonRequest($this->request);

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
        $userId = (int)$this->request->attributes->get('user_id');
        $taskId = (int)$this->request->attributes->get('task_id');
        $data = $this->getJsonRequest($this->request);

        $taskService = new TaskService();
        $response = $taskService->updateTask($data, $userId, $taskId);

        return $this->json($response);
    }

    /**
     * Delete Task
     *
     * @return JsonResponse
     */
    public function deleteTask()
    {
        $taskId = (int)$this->request->attributes->get('task_id');
        $data = $this->getJsonRequest($this->request);

        $taskService = new TaskService();
        $response = $taskService->deleteTask($taskId, $data['access_token']);

        return $this->json($response);
    }

    /**
     * Allocate task to user.
     *
     * @return JsonResponse
     */
    public function allocateTask()
    {
        $userId = (int)$this->request->attributes->get('user_id');
        $taskId = (int)$this->request->attributes->get('task_id');
        $data = $this->getJsonRequest($this->request);

        $taskService = new TaskService();
        $response = $taskService->allocateTaskTo($userId, $taskId, $data['access_token']);

        return $this->json($response);
    }

    /**
     * Deallocate task from user.
     *
     * @return JsonResponse
     */
    public function deallocateTask()
    {
        $userId = (int)$this->request->attributes->get('user_id');
        $taskId = (int)$this->request->attributes->get('task_id');
        $data = $this->getJsonRequest($this->request);

        $taskService = new TaskService();
        $response = $taskService->deallocateTask($userId, $taskId, $data['access_token']);

        return $this->json($response);
    }
}
