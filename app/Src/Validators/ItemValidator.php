<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class ItemValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'numeric|nullable|exists:users,id',
            'name' => 'string|required|max:100',
            'icon' => 'required|image|mimes:jpg,jpeg,png|max:1000',
            'price' => 'numeric|required|min:1000|max:500000',
            'description' => 'nullable|string|max:150',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:items,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:items,id',
            'name' => 'string|required|max:100',
            'icon' => 'nullable|image|mimes:jpg,jpeg,png|max:1000',
            'price' => 'numeric|required|min:1000|max:500000',
            'description' => 'nullable|string|max:150',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateChangeIcon(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:items,id',
            'icon' => 'required|image|mimes:jpg,jpeg,png|max:1000',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}