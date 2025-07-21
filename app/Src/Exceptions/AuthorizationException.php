<?php

namespace App\Src\Exceptions;

use App\Src\Helpers\StatusCode;

class AuthorizationException extends ClientException {

    public function __construct($message = "Unauthorized", $errors, int $code = StatusCode::HTTP_UNAUTHORIZED) {
        parent::__construct($message, $errors, $code);
    }

}