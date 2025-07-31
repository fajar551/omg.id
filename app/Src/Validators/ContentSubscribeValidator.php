<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class ContentSubscribeValidator {
    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'content_id' => 'numeric|required|exists:contents,id',
            'supporter_id' => 'numeric|nullable|exists:users,id',
            'email' => 'nullable|string|email|max:255',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}
