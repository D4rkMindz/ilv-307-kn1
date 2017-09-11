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
        $userValidation = new UserValidation();
        $validationContext = $userValidation->validate($data);
        if (!$validationContext->success()){
            return $validationContext->toArray();
        }

        if(!$this->hasPermission($data['access_token'], ADMIN)){
            return ['status'=> 'error', 'error'=> 'ACTION_NOT_ALLOWED'];
        }

        $user = $this->getUser($data['access_token']);

        $personRow = $this->mapPersonRow($data, $user);
        $peopleTable = new PeopleTable();
        $personId = $peopleTable->insert($personRow);

        $userRow = $this->mapUserRow($data, $user, $personId);
        $userTable = new UserTable();
        $userId = $userTable->insert($userRow);

        return ['status' => 'success', 'user_id'=> $userId];
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
            'person_id'=> $personId,
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
            'postcode_id'=> $postCodeId,
            'first_name'=> $data['firstName'],
            'last_name'=> $data['lastName'],
            'address'=> $data['address'],
            'created'=> date('Y-m-d H:i:s'),
            'created_by'=>$user['id'],
        ];
        return $personRow;
    }
}
