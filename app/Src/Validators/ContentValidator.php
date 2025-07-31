<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class ContentValidator {

    /**
     * @deprecated
     * use validateStore2
     */
    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|required',
            'content' => 'string|nullable',
            'category_id' => 'numeric|required|exists:content_categories,id',
            'thumbnail' => 'required|image|mimes:jpg,jpeg,png|max:2000',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'unit_access' => 'numeric|nullable',
            'file' => 'nullable|file|max:15000|mimes:image/*,video/*,audio/*,pdf,zip,x-gzip,x-zip-compressed,application/pdf,application/vnd.ms-excel,application/msword,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'external_link' => 'nullable|string',
            'status' => 'numeric|nullable|in:0,1',
            'sensitive_content' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

     /**
     * @deprecated
     * use validateUpdate2
     */
    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:contents,id',
            'title' => 'string|nullable',
            'content' => 'string|nullable',
            'category_id' => 'numeric|nullable|exists:content_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'unit_access' => 'numeric|nullable',
            'file' => 'nullable|file|max:50000|mimes:image/*,video/*,audio/*,pdf,zip,x-gzip,x-zip-compressed,application/pdf,application/vnd.ms-excel,application/msword,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation',
            'external_link' => 'nullable|string',
            'status' => 'numeric|nullable|in:0,1',
            'sensitive_content' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    /**
     * @deprecated
     * use validateContentID
     */
    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:contents,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateStore2(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|required|max:255',
            // 'content' => 'string|nullable',
            'body' => 'string|required',
            'category_id' => 'nullable|exists:content_categories,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'item_id' => 'required|numeric',
            'attachment' => @$data["attachment"] ? 'required|file|max:50000|mimetypes:image/*,video/*,audio/*,pdf,zip,x-gzip,x-zip-compressed,application/pdf,application/vnd.ms-excel,application/msword,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation' : 'nullable',
            'external_link' => 'nullable|string|url',
            'status' => 'numeric|nullable|in:0,1',
            'sensitive_content' => 'nullable|boolean'
        ])->validate();
    }

    /**
     * Validate when new data created.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateUpdate2(array $data)
    {
        return Validator::make($data, [
            'id' => 'numeric|required|exists:contents,id',
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|required|max:255',
            // 'content' => 'string|nullable',
            'body' => 'string|required',
            'category_id' => 'nullable|exists:content_categories,id',
            'thumbnail' => @$data["thumbnail"] ? 'required|image|mimes:jpg,jpeg,png' : 'nullable',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png',
            'item_id' => 'required|numeric',
            'attachment' => @$data["attachment"] ? 'required|file|max:50000|mimetypes:image/*,video/*,audio/*,pdf,zip,x-gzip,x-zip-compressed,application/pdf,application/vnd.ms-excel,application/msword,application/pdf,application/vnd.ms-excel,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,application/vnd.ms-powerpoint,application/vnd.openxmlformats-officedocument.presentationml.presentation' : 'nullable',
            'external_link' => 'nullable|string',
            'status' => 'numeric|nullable|in:0,1',
            'sensitive_content' => 'nullable|boolean'
        ])->validate();
    }

    /**
     * Validate a model id.
     *
     * @param string $id
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateContentID(int $id)
    {
        return Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:contents,id',
        ])->validate();
    }
    
    /**
     * Validate a model id.
     *
     * @param array $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    public function validateContentWithUserID(array $data)
    {
        return Validator::make($data, [
            'id' => 'numeric|required|exists:contents,id',
            'user_id' => 'numeric|required|exists:users,id',
        ])->validate();
    }
}