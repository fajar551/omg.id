<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class ReportValidator {
    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'string|required',
            'email' => 'required|string|email',
            'link' => 'string|required',
            'screenshot' => 'required|image|mimes:jpg,jpeg,png|max:1000',
            'category' => 'array|required',
            'description' => 'string|nullable',
            'creator_id' => 'numeric|nullable',
            'content_id' => 'numeric|nullable'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:reports,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

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