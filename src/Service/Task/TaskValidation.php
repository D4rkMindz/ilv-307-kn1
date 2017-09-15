<?php

namespace App\Service\Task;

use App\Table\TaskTable;
use App\Table\UserTable;
use App\Util\ValidationContext;

/**
 * Class TaskValidation
 */
class TaskValidation
{
    /**
     * Validate task data.
     *
     * Required array keys:
     *
     * string   access_token
     * int      userId
     * string   title
     * string   description
     * datetime dueDate (Y-m-d H:i:s)
     *
     * @param array $data
     * @return ValidationContext
     */
    public function validateAddTask(array $data): ValidationContext
    {
        $validationContext = new ValidationContext(__('Please check your data'));

        $this->existsTaskByTitle($data['title'], $validationContext);
        $this->validateUser($data['userId'], $validationContext);
        $this->validateLength($data['title'], 'title', $validationContext, 5, 45);
        $this->validateLength($data['description'], 'description', $validationContext, 10, 65535);
        $this->validateDueDate($data['dueDate'], $validationContext);

        return $validationContext;
    }

    /**
     * Validate task update data.
     *
     * Required array keys:
     *
     * int      id
     * int      userId
     *
     * Optional array keys (at least one):
     *
     * string   access_token
     * int      userId
     * string   title
     * string   description
     * datetime dueDate (Y-m-d H:i:s)
     *
     * @param array $data
     * @return ValidationContext
     */
    public function validateUpdateTask(array $data): ValidationContext
    {
        $updated = false;
        $validationContext = new ValidationContext(__('Please check your data'));

        if (!array_key_exists('id', $data)) {
            $validationContext->setError('id', __('required'));
        } else {
            $this->existsTaskById($data['id'], $validationContext);
        }

        if (!array_key_exists('userId', $data)) {
            $validationContext->setError('userId', __('required'));
        } else {
            $this->validateUser($data['userId'], $validationContext);
        }

        if (array_key_exists('description', $data)) {
            $this->validateLength($data['description'], 'description', $validationContext, 10, 65535);
            $updated = true;
        }

        if (array_key_exists('title', $data)) {
            $this->validateLength($data['title'], 'title', $validationContext, 5, 45);
            $this->existsTaskByTitle($data['title'], $validationContext, true);
            $updated = true;
        }

        if (array_key_exists('dueDate', $data)) {
            $this->validateDueDate($data['dueDate'], $validationContext);
            $updated = true;
        }

        if (!$updated) {
            $validationContext->setError('main', __('No valid array keys found'));
        }

        return $validationContext;
    }

    /**
     * Validate user.
     *
     * @param int $userId
     * @param ValidationContext $validationContext
     * @return void
     */
    protected function validateUser(int $userId, ValidationContext $validationContext)
    {
        if (!is_numeric($userId)) {
            $validationContext->setError('user', __('Impossible user id'));
        }

        $userTable = new UserTable();
        if (!$userTable->existsId($userId)){
            $validationContext->setError('user', __('User does not exist'));
        }
    }

    /**
     * Check if task exists.
     *
     * @param string $title - task title
     * @param ValidationContext $validationContext
     * @param bool $update - true if validateInsert data is for an update
     * @return void
     */
    protected function existsTaskByTitle(string $title, ValidationContext $validationContext, bool $update = false)
    {
        $taskTable = new TaskTable();
        $taskFound = $taskTable->existsTaskByTile($title);
        if ($taskFound && !$update) {
            $validationContext->setError('tasks', __('Task already exists'));
        }

        if (!$taskFound && $update) {
            $validationContext->setError('tasks', __('Task does not exist'));
        }
    }

    /**
     * Check if task exists.
     *
     * @param int $id - task ID
     * @param ValidationContext $validationContext
     * @return void
     */
    protected function existsTaskById(int $id, ValidationContext $validationContext)
    {
        $taskTable = new TaskTable();
        if (!$taskTable->existsTask($id)) {
            $validationContext->setError('tasks', __('Task does not exist'));
        }
    }

    /**
     * Validate due date.
     *
     * @param $dueDate
     * @param ValidationContext $validationContext
     * @return void
     */
    protected function validateDueDate($dueDate, ValidationContext $validationContext)
    {
        if (empty($dueDate)) {
            $validationContext->setError('due_date', __('Please enter a due date'));

            return;
        }

        $regEx = '/^(((\d{4})(-)(0[13578]|10|12)(-)(0[1-9]|[12][0-9]|3[01]))|((\d{4})(-)(0[469]|1‌​1)(-)([0][1-9]|[12][0-9]|30))|((\d{4})(-)(02)(-)(0[1-9]|1[0-9]|2[0-8]))|(([02468]‌​[048]00)(-)(02)(-)(29))|(([13579][26]00)(-)(02)(-)(29))|(([0-9][0-9][0][48])(-)(0‌​2)(-)(29))|(([0-9][0-9][2468][048])(-)(02)(-)(29))|(([0-9][0-9][13579][26])(-)(02‌​)(-)(29)))(\s([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9]))$/';
        if (!preg_match($regEx, $dueDate)) {
            $validationContext->setError('due_date', __('Not a valid datetime format'));

            return;
        }

        if (date('Y-m-d H:i:s') > date('Y-m-d H:i:s', $dueDate)) {
            $validationContext->setError('due_date', __('Due Date can not be in the past'));
        }
    }

    /**
     * Validate the length of a value
     *
     * @param string $value - value to validateAddTask
     * @param string $type - type of the value (e.g. first_name)
     * @param ValidationContext $validationContext
     * @param int $min - default 3, optional, minimum length
     * @param int $max - default 255, optional, maximum length
     * @return void
     */
    protected function validateLength(
        string $value,
        string $type,
        ValidationContext $validationContext,
        int $min = 3,
        int $max = 255
    ) {
        $lenght = strlen(trim($value));
        if ($lenght < $min) {
            $validationContext->setError($type, __('Too short'));
        }

        if ($lenght > $max) {
            $validationContext->setError($type, __('Too long'));
        }
    }
}
