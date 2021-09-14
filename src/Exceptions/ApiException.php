<?php

namespace App\Exceptions;

use Throwable;

class ApiException extends \Exception
{
    public function __construct($message = "", $code = 500, Throwable $previous = null)
    {
        if (is_array($message)) {
            $message = json_encode($message);
        }

        parent::__construct($message, $code, $previous);
    }
}
