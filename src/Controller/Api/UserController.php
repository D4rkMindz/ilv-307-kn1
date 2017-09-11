<?php

namespace App\Controller\Api;

use App\Service\User\UserService;
use App\Table\UserTable;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * Class UserController
 */
class UserController extends ApiController
{
    /**
     * Get All users.
     *
     * @return JsonResponse
     */
    public function getUsers(): JsonResponse
    {
        $userTable = new UserTable();
        $data = $userTable->getAll();
        if (empty($data)) {
            return $this->returnError(__('no users available'), 'ERROR_NO_USR_AVAILABLE', 500);
        }

        return $this->json($data);
    }

    /**
     * Get single user.
     *
     * @return JsonResponse
     */
    public function getUser(): JsonResponse
    {
        $userId = $this->request->attributes->get('user_id');
        $userTable = new UserTable();
        $userRow = $userTable->getUserById($userId);
        if (empty($userRow)) {
            return $this->returnError(__('Please enter a valid USER_ID'));
        }

        return $this->json($userRow, 200);
    }

    /**
     * Add new User.
     *
     * Required array keys:
     *
     * string   username
     * string   firstName
     * string   lastName
     * string   address
     * int      postcode
     *
     * @return JsonResponse
     */
    public function addUser(): JsonResponse
    {
        $data = $this->getJsonRequest(request());
        $userService = new UserService();
        $response = $userService->addNewUser($data);
        return $this->json($response);
    }

    /**
     * Update User.
     *
     * @return JsonResponse
     */
    public function updateUser(): JsonResponse
    {
        $userId = $this->request->attributes->get('user_id');

        //TODO
        return $this->returnError('under construction', 'ERROR_ATM_NOT_AVAILABLE', 500);
    }

    /**
     * Delete User
     *
     * @return JsonResponse
     */
    public function deleteUser(): JsonResponse
    {
        $userId = $this->request->attributes->get('user_id');

        //TODO
        return $this->returnError('under construction', 'ERROR_ATM_NOT_AVAILABLE', 500);
    }
}
