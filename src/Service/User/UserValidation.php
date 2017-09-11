<?php

namespace App\Service\User;

use App\Table\PostCodeTable;
use App\Table\UserTable;
use App\Util\ValidationContext;

/**
 * Class UserValidation
 */
class UserValidation
{
    /**
     * Validate user data.
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
     * @return ValidationContext
     */
    public function validate(array $data): ValidationContext
    {
        $validationContext = new ValidationContext(__('Please check your data'));
        $this->validateUsername($data['username'], $validationContext);
        $this->validateName($data['firstName'], 'first_name', $validationContext);
        $this->validateName($data['lastName'], 'last_name', $validationContext);
        $this->validateAddress($data['address'], $validationContext);
        $this->validatePostcode($data['postcode'], $validationContext);

        return $validationContext;
    }

    /**
     * Validate username.
     *
     * @param string $username
     * @param ValidationContext $validationContext
     * @return void
     */
    protected function validateUsername(string $username, ValidationContext $validationContext)
    {
        $this->validateLength($username, 'username', $validationContext);
        $userTable = new UserTable();
        if ($userTable->existsUsername($username)) {
            $validationContext->setError('username', __('Username already exists'));
        }
    }

    /**
     * Validate name.
     *
     * @param string $name - either firstName or lastName
     * @param string $type - either first_name or last_name
     * @param ValidationContext $validationContext
     * @return void
     */
    protected function validateName(string $name, string $type, ValidationContext $validationContext)
    {
        $this->validateLength($name, $type, $validationContext, 2, 255);
    }

    /**
     * Validate address.
     *
     * @param string $address
     * @param ValidationContext $validationContext
     * @return void
     */
    protected function validateAddress(string $address, ValidationContext $validationContext)
    {
        $this->validateLength($address, 'address', $validationContext, 4, 255);
    }

    /**
     * Validate postcode.
     *
     * @param int $postcode
     * @param ValidationContext $validationContext
     * @return void
     */
    protected function validatePostcode(int $postcode, ValidationContext $validationContext)
    {
        $this->validateLength((int)$postcode, 'postcode', $validationContext, 4, 4);
        $postCodeTable = new PostCodeTable();
        if (!$postCodeTable->existsPostCode($postcode)) {
            $validationContext->setError('postcode', __('Postcode does not exist in Switzerland'));
        }
    }

    /**
     * Validate the length of a value
     *
     * @param string $value - value to validate
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
