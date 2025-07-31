<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PageValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'page_url' => 'string|required',
            // 'category_id' => 'numeric|nullable|exists:pages_categories,id',
            'name' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:pages,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validatePageurl(string $pageurl)
    {
        $validator = Validator::make(["page_url" => $pageurl], [
            'page_url' => 'string|required|exists:pages,page_url',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateProfile(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:pages,id',
            'bio' => 'string|nullable',
            'page_url' => 'string|nullable',
            'avatar' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'name' => 'required|string|max:50'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateVideo(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:pages,id',
            'video' => 'nullable|string|url',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}