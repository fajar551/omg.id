<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PayoutAccountValidator {
    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'channel_code' => 'string|required',
            'account_name' => 'string|required|alpha_spaces',
            'account_number' => 'numeric|required',
            'type' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:payout_accounts,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:payout_accounts,id',
            'channel_code' => 'string|required',
            'account_name' => 'string|required|alpha_spaces',
            'account_number' => 'numeric|required',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}