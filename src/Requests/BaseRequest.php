<?php

namespace App\Requests;

use App\Helpers\ValidatorHelper;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseRequest
{
    protected $validationHelper;
    protected $em;

    public function __construct(ValidatorHelper $validatorHelper, EntityManagerInterface $em)
    {
        $this->validationHelper = $validatorHelper;
        $this->em = $em;
    }

    /**
     * @param array $errors
     * @return array
     */
    protected function prepareErrors(array $errors): array
    {
        foreach ($errors as $key => $value) {
            if (is_array($value) && count($value) === 0) {
                unset($errors[$key]);
            }
        }

        return $errors;
    }

    abstract function validate(Request $request);
}
