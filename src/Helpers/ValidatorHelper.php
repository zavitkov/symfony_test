<?php

namespace App\Helpers;

use App\Exceptions\ApiException;
use Symfony\Component\Validator\ValidatorBuilder;

class ValidatorHelper
{
    public static function checkErrors(array $errors)
    {
        if (count($errors) > 0) {
            throw new ApiException($errors, 400);
        }
    }

    public static function validateValue($value, $constraints): array
    {
        $validator = ((new ValidatorBuilder())->getValidator());
        $errors = [];

        if (is_array($value) && sizeof($value)) {
            foreach ($value as $arr_value) {
                $errors = array_merge($errors, $validator->validate($arr_value, $constraints));
            }
        } else {
            $errors = $validator->validate($value, $constraints);
        }

        $error_messages = [];
        foreach ($errors as $error) {
            $error_messages[] = $error->getMessage();
        }

        return $error_messages;
    }
}
