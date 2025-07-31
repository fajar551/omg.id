<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PaymentMethodValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'string|required',
            'payment_type' => 'string|required',
            'bank_name' => 'string|nullable',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:payment_methods,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:payment_methods,id',
            'name' => 'string|required',
            'payment_type' => 'string|required',
            'bank_name' => 'string|nullable',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateChangeIcon(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:payment_methods,id',
            'image' => 'required|image|mimes:jpg,jpeg,png|max:2000',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}