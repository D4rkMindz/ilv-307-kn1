<?php


namespace App\Service\Index;


use App\Util\ValidationContext;

/**
 * Class IndexValidation
 */
class IndexValidation
{
    /**
     * Basic validation
     *
     * @todo replace this function with your own
     * @param array $data
     * @return ValidationContext $validationContext
     */
    public function basicValidation(array $data): ValidationContext
    {
        $validationContext = new ValidationContext(__('Please Check your data'));
        $this->validateName($data['name'], $validationContext);
        return $validationContext;
    }

    /**
     * Validate name function.
     *
     * This function may be replaced by your own.
     *
     * @param string $name
     * @param ValidationContext $validationContext
     */
    protected function validateName(string $name, ValidationContext $validationContext)
    {
        if (strlen(trim($name)) <= 3){
            $validationContext->setError('name', __('Name not valid'));
        }
    }
}
