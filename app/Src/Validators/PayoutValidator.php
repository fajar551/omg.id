<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PayoutValidator {

    public function validateExternalid(string $external_id)
    {
        $validator = Validator::make(["external_id" => $external_id], [
            'external_id' => 'string|required|exists:payouts,external_id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateAmount($data)
    {
        $messages = [
            'amount.min' => __("message.minimum_payout"),
        ];

        $validator = Validator::make($data, [
            'amount' => 'numeric|required|min:50000',
        ], $messages);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}