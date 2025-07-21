<?php

namespace App\Src\Exceptions;

use App\Src\Helpers\StatusCode;

class NotFoundException extends ClientException {

    public function __construct($message = "Bad Request", $errors, int $code = StatusCode::HTTP_BAD_REQUEST) {
        parent::__construct($message, $errors, $code);
    }

}