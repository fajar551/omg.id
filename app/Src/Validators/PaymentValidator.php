<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PaymentValidator {
    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'creator_id' => 'numeric|required|exists:users,id',
            'name' => 'string|required',
            'email' => 'required|string|email',
            'type' => 'numeric|required|in:1,2',
            'message' => 'nullable|string',
            'content_id' => $data['type'] == 2 ? 'required|numeric|exists:contents,id' : 'nullable',
            'payment_method_id' => 'numeric|required|exists:payment_methods,id',
            'page_url' => 'string|required|exists:pages,page_url',
            'items' => 'required|array',
            'media_share' => 'nullable|array',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    // public function validateId(int $id)
    // {
    //     $validator = Validator::make(["id" => $id], [
    //         'id' => 'numeric|required|exists:pages_categories,id',
    //     ]);

    //     if ($validator->fails()) {
    //         throw new NotFoundException(__("message.notfound"), $validator->errors());
    //     }

    //     return true;
    // }

    // public function validateUpdate(array $data)
    // {
    //     $validator = Validator::make($data, [
    //         'id' => 'required|numeric|exists:pages_categories,id',
    //         'title' => 'string|nullable'
    //     ]);

    //     if ($validator->fails()) {
    //         throw new ValidatorException(__("message.validation_failed"), $validator->errors());
    //     }

    //     return true;
    // }
}