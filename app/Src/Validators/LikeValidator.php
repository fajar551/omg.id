<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class LikeValidator 
{
    /**
     * Validate like payload.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateLike(array $data)
    {
        $rules = [
            'user_id' => 'required|numeric|exists:users,id',
            'type' => 'required|in:posts,content,comment',
        ];

        if (isset($data["post_id"])) {
            $rules["post_id"] = 'required|numeric|exists:posts,id';
        } else if (isset($data["content_id"])) {
            $rules["content_id"] = 'required|numeric|exists:contents,id';
        } else if (isset($data["comment_id"])) {
            $rules["comment_id"] = 'required|numeric|exists:comments,id';
        }

        return Validator::make($data, $rules)->validate();
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:post_likes,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

}