<?php


namespace App\Service\ShoppingCart;


use App\Util\ValidationContext;

class OrderValidation
{
    public function validate(array $data): ValidationContext
    {
        $validationContext = new ValidationContext('Bitte überprüfen Sie ihre Eingabe');
        $this->validateLength($data, $validationContext);
        $this->validateEmail($data['mail'], $validationContext);
        return $validationContext;
    }

    /**
     * Validate length
     *
     * @param array $data
     * @param ValidationContext $validationContext
     */
    private function validateLength(array $data, ValidationContext $validationContext): void
    {
        foreach ($data as $key => $item) {
            if ($key !== 'birthday' && empty($item)) {
                $validationContext->setError($key, 'Benötigt');
            }
        }
    }

    /**
     * Validate email address.
     *
     * @param string $email
     * @param ValidationContext $validationContext
     */
    private function validateEmail(string $email, ValidationContext $validationContext)
    {
        if (!is_email($email)) {
            $validationContext->setError('mail', 'Keine gültige Email Adresse');
        }
    }
}
