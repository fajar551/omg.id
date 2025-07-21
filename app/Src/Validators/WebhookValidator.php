<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use Validator;

class WebhookValidator {

    public function validateWebhook(array $data)
    {
        $validator = Validator::make($data, [
            'userid' => 'numeric|required|exists:users,id',
            'type' => 'required|array',
            'type.*' => 'required|string|in:discord_webhook,custom_webhook',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}