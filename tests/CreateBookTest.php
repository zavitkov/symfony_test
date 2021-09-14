<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateBookTest extends WebTestCase
{
    public function testCreationBook(): void
    {
        $expected = [
            'success' => true,
            'data' => new \ArrayObject(),
            'message' => 'Книга успешно добавлена'
        ];

        $client = static::createClient();
        $client->request('POST', '/api/book/create', [
            'name_en' => 'test_book_name',
            'name_ru' => 'тестовое_название_книги',
            'author_id' => 2
        ]);

        $response = $client->getResponse()->getContent();

        $this->assertJsonStringEqualsJsonString(json_encode($expected), $response);
    }
}
