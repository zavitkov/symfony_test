<?php

namespace App\EventListener;

use App\Exceptions\ApiException;
use App\Responses\ApiResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ApiExceptionListener
{
    public function onKernelException(ExceptionEvent $event)
    {
        $exception = $event->getThrowable();

        if ($exception instanceof ApiException) {
            $errors = $exception->getMessage();

            if ($this->isJson($errors)) {
                $errors = json_decode($errors, true);
            }

            $response = new ApiResponse('Возникла ошибка', $errors, false, $exception->getCode());

            $event->setResponse($response);
        }
    }

    private function isJson($string) {
        json_decode($string);
        return json_last_error() === JSON_ERROR_NONE;
    }
}
