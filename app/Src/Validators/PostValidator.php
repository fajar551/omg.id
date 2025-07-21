<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PostValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|required',
            'description' => 'string|nullable',
            'post_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'pinned' => 'numeric|nullable|in:0,1',
            'status' => 'numeric|nullable|in:0,1',
            'scheduled_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:posts,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:posts,id',
            // 'user_id' => 'numeric|required|exists:users,id',
            'description' => 'string|nullable',
            'post_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'pinned' => 'numeric|nullable|in:0,1',
            'status' => 'numeric|nullable|in:0,1',
            'scheduled_at' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}