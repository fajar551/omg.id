<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PageTemplateValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'title' => 'string|required',
            'image' => 'required|image|mimes:jpg,jpeg,png',
            'category' => 'numeric|nullable|in:0,1',
            'price' => 'numeric|required',
            'directory_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:pages_templates,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:pages_templates,id',
            'title' => 'string|required',
            'image' => 'required|image|mimes:jpg,jpeg,png',
            'category' => 'numeric|nullable|in:0,1',
            'price' => 'numeric|required',
            'directory_name' => 'required|string'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}