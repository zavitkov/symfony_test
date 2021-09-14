<?php

namespace App\Requests;

use App\Helpers\ValidatorHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AddAuthorRequest extends BaseRequest
{
    function validate(Request $request)
    {
        $errors = [];

        $name = $request->get('name');

        $errors = array_merge(
            $errors,
            [
                'name' => ValidatorHelper::validateValue(
                    $name,
                    [
                        new NotBlank(['message' => 'Поле не должно быть пустым']),
                        new NotNull(null, 'Поле должно быть заполнено'),
                    ]
                ),
            ]
        );

        return $this->prepareErrors($errors);
    }
}
