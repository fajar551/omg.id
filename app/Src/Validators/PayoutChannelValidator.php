<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PayoutChannelValidator {
    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'string|required',
            'channel_code' => 'string|required'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:payout_channels,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:payout_channels,id',
            'title' => 'string|nullable',
            'channel_code' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}