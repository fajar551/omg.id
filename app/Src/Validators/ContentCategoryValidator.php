<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class ContentCategoryValidator {

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateStore(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|required|min:3|max:191',
        ])->validate();
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:content_categories,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:content_categories,id',
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|nullable'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}