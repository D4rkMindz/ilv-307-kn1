<?php

namespace App\Service\User;

use App\Service\AppService;
use App\Table\PeopleTable;
use App\Table\PostCodeTable;
use App\Table\UserTable;

/**
 * Class UserService
 */
class UserService extends AppService
{
    /**
     * Add new user.
     *
     * Required array keys:
     *
     * string   username
     * string   firstName
     * string   lastName
     * string   address
     * int      postcode
     *
     * @param array $data
     * @return array
     */
    public function addNewUser(array $data): array
    {
        //TODO: Remove for AUTH
        /*if (!$this->hasPermission($data['access_token'], ADMIN)) {
            return ['status' => 'error', 'error' => 'ACTION_NOT_ALLOWED'];
        }*/

        $userValidation = new UserValidation();
        $validationContext = $userValidation->validateInsert($data);
        if (!$validationContext->success()) {
            return ['status' => 'error', 'message' => $validationContext->toArray()];
        }

        //TODO: remove for AUTH
        //$user = $this->getUser($data['access_token']);
        $user = ['id' => 2, 'role_id' => 1];

        $personRow = $this->mapPersonRow($data, $user);
        $peopleTable = new PeopleTable();
        $personId = $peopleTable->insert($personRow);

        $userRow = $this->mapUserRow($data, $user, $personId);
        $userTable = new UserTable();
        $userId = $userTable->insert($userRow);

        return ['status' => 'success', 'user_id' => $userId];
    }

    /**
     * Update user.
     *
     * @param array $data
     * @param int $userId
     * @return array
     */
    public function updatedUser(array $data, int $userId): array
    {
        //TODO remove this for auth
        //if (!$this->hasPermission($data['access_token'], USER_PLUS)) {
        //    return ['status' => 'error', 'error' => 'ACTION_NOT_ALLOWED'];
        //}

        $userValidation = new UserValidation();
        $validationContext = $userValidation->validateUpdate($data, $userId);

        if (!$validationContext->success()) {
            return ['status' => 'error', 'message' => $validationContext->toArray()];
        }

        $response = ['status' => 'success'];

        //$user = $this->getUser($data['access_token']);
        $user = ['id' => 1, 'level' => 4, 'role_id' => 1];
        $userRow = $this->mapUserUpdateRow($data, $user);
        $personRow = $this->mapPersonUpdateRow($data, $user);

        if ($personRow['update']) {
            unset($personRow['update']);
            $peopleTable = new PeopleTable();
            $peopleTable->update($personRow, $data['personId']);
            $response['person_id'] = $data['personId'];
        }

        if ($userRow['update']) {
            unset($userRow['update']);
            $userTable = new UserTable();
            $userTable->update($userRow, $userId);
            $response['user_id'] = $userId;
        }

        return $response;
    }

    /**
     * Delete user.
     *
     * @param int $userId
     * @param string $accessToken
     * @return array
     */
    public function deleteUser(int $userId, string $accessToken): array
    {
        if (!$this->hasPermission($accessToken, ADMIN)) {
            return ['status' => 'error', 'error' => 'ACTION_NOT_ALLOWED'];
        }

        $executor = $this->getUser($accessToken);

        $userTable = new UserTable();
        $userTable->deleteUser($userId, $executor['id']);

        return ['status' => 'success', 'user_id' => $userId];
    }

    /**
     * Map user row.
     *
     * @param array $data - user data to map
     * @param array $user - user data to map
     * @param int $personId - person ID
     * @return array $userRow - mapped user row
     */
    protected function mapUserRow(array $data, array $user, int $personId): array
    {
        $userRow = [
            'role_id' => $user['role_id'],
            'person_id' => $personId,
            'oauth_clients_id' => 1,
            'username' => $data['username'],
            'password' => password_hash($data['password'], PASSWORD_DEFAULT),
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $user['id'],
        ];

        return $userRow;
    }

    /**
     * Map person row.
     *
     * @param array $data - person data
     * @param array $user - executing user data
     * @return array $personRow - formatted person data
     */
    protected function mapPersonRow(array $data, array $user): array
    {
        $postCodeTable = new PostCodeTable();
        $postCodeId = $postCodeTable->getIdByPostCode($data['postcode']);
        $personRow = [
            'postcode_id' => $postCodeId,
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'address' => $data['address'],
            'created' => date('Y-m-d H:i:s'),
            'created_by' => $user['id'],
        ];

        return $personRow;
    }

    /**
     * Map user row for update.
     *
     * @param array $data
     * @param $user
     * @return array
     */
    protected function mapUserUpdateRow(array $data, $user): array
    {
        $update = false;
        $userRow = [
            'modified' => date('Y-m-d H:i:s'),
            'modified_by' => $user['id'],
        ];

        if (array_key_exists('username', $data)) {
            $userRow['username'] = $data['username'];
            $update = true;
        }

        if (array_key_exists('password', $data)) {
            $userRow['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
            $update = true;
        }

        $userRow['update'] = $update;

        return $userRow;
    }

    /**
     * Map person update row.
     *
     * @param array $data
     * @param array $user
     * @return array
     */
    protected function mapPersonUpdateRow(array $data, array $user): array
    {
        $update = false;
        $personRow = [
            'modified' => date('Y-m-d H:i:s'),
            'modified_by' => $user['id'],
        ];

        if (array_key_exists('postcode', $data)) {
            $postCodeTable = new PostCodeTable();
            $postCodeId = $postCodeTable->getIdByPostCode($data['postcode']);
            $personRow['postcode'] = $postCodeId;
            $update = true;
        }

        if (array_key_exists('firstName', $data)) {
            $personRow['first_name'] = $data['firstName'];
            $update = true;
        }

        if (array_key_exists('lastName', $data)) {
            $personRow['last_name'] = $data['lastName'];
            $update = true;
        }

        if (array_key_exists('address', $data)) {
            $personRow['address'] = $data['address'];
            $update = true;
        }

        $personRow['update'] = $update;

        return $personRow;
    }
}
