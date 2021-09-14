<?php

namespace App\Responses;

use Symfony\Component\HttpFoundation\JsonResponse;

class ApiResponse extends JsonResponse
{
    public function __construct($message = '', $data = null, $success = true, int $status = 200, array $headers = [], bool $json = false)
    {
        parent::__construct($this->format($message, $data, $success), $status, $headers, $json);
    }

    private function format($message = '', $data = null, $success = true)
    {
        if ($data === null) {
            $data = new \ArrayObject();
        }

        $response = [
            'success' => $success,
            'message' => $message,
            'data'    => $data,
        ];

        return $response;
    }
}
