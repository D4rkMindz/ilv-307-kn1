<?php


namespace App\Service\Weather;


use App\Util\ValidationContext;

/**
 * Class CityValidation
 */
class CityValidation
{
    /**
     * Validate city input.
     *
     * @param array $data
     * @return ValidationContext
     */
    public static function validate($data)
    {
        $validationContext = new ValidationContext('Bitte überprüfen Sie Ihre Eingabe');
        if (!array_key_exists('city', $data)){
            $validationContext->setError('city', 'Bitte geben Sie eine Stadt ein');
            return $validationContext;
        }
        if (empty($data['city'])){
            $validationContext->setError('city', 'Bitte geben Sie eine Stadt ein');
        }
        return $validationContext;
    }
}
