<?php

namespace App\Service\User;

use App\Service\AppService;

/**
 * Class UserService
 *
 * @package App\Service
 */
class UserService extends AppService
{
    /**
     * Add new user.
     *
     * @param array $data
     * @return array
     */
    public function addNewUser(array $data): array
    {
        $userValidation = new UserValidation();
        $validationContext = $userValidation->validateUser($data);
        if (!$validationContext->success()){
            return $validationContext->toArray();
        }
        // TODO insert User
        return ['error' => 'under construction'];
    }

    /**
     * Map user row.
     *
     * @param array $data - user data to map
     * @return array $userRow - mapped user row
     */
    protected function mapUserRow(array $data): array
    {
        $userRow = [
            'username'=>$data['username'],
            'created' => date('Y-m-d h:i:s'),
            'created_by'=> '1',
        ];
        //TODO: finish function map user row
        return $userRow;
    }
}
