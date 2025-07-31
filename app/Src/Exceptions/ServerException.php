<?php

namespace App\Src\Exceptions;

use App\Src\Helpers\StatusCode;
use Exception;

class ServerException extends Exception
{
    protected $errors;
    
    public function __construct($message = null, $errors = null, $code = StatusCode::HTTP_INTERNAL_SERVER_ERROR)
    {
        parent::__construct($message, $code);

        $this->errors = $errors;
    }

    public function getErrors()
    {
        return $this->errors;
    }
}
