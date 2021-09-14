<?php

namespace App\Requests;

use App\Entity\Author;
use App\Helpers\ValidatorHelper;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AddBookRequest extends BaseRequest
{
    function validate(Request $request)
    {
        $errors = [];

        $common_rules = [
            new NotBlank(['message' => 'Поле не должно быть пустым']),
            new NotNull(null, 'Поле должно быть заполнено'),
        ];

        $author_id = $request->get('author_id');
        $name_en = $request->get('name_en');
        $name_ru = $request->get('name_ru');

        $errors = array_merge(
            $errors,
            [
                'author_id' => ValidatorHelper::validateValue(
                    $author_id,
                    $common_rules
                ),

                'name_en' => ValidatorHelper::validateValue(
                    $name_en,
                    $common_rules
                ),

                'name_ru' => ValidatorHelper::validateValue(
                    $name_ru,
                    $common_rules
                ),
            ]
        );

        if ($author_id) {
            if (!$this->em->getRepository(Author::class)->find($author_id)) {
                $errors = array_merge(
                    $errors, ['author_id' => ['Данного автора не существует']]
                );
            }
        }

        return $this->prepareErrors($errors);
    }
}
