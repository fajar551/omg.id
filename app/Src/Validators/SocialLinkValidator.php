<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class SocialLinkValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'socials' => 'required|array',
            'socials.*' => 'nullable|string|min:3|alpha_dash_dot',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateUserId(int $id)
    {
        $validator = Validator::make(["user_id" => $id], [
            'user_id' => 'numeric|required|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

}