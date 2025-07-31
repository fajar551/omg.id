<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class CommentValidator 
{

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateStore(array $data)
    {
        $rules = [
            'user_id' => 'required|numeric|exists:users,id',
            'body' => 'string|required',
        ];

        if (isset($data["post_id"])) {
            $rules["post_id"] = 'required|numeric|exists:posts,id';
        } else if (isset($data["content_id"])) {
            $rules["content_id"] = 'required|numeric|exists:contents,id';
        }

        return Validator::make($data, $rules)->validate();
    }

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUpdate(array $data)
    {
        return Validator::make($data, [
            'id' => 'required|numeric|exists:comments,id',
            'user_id' => 'required|numeric|exists:users,id',
            'body' => 'string|required',
        ])->validate();
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:comments,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

}