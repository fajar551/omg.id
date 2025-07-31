<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use Validator;

class AuthValidator {

    public function validateRegister(array $data)
    {
        $validator = Validator::make($data, [
            'username' => 'required|string|max:100|alpha_dash_dot|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateLogin(array $data)
    {
        $validator = Validator::make($data, [
            'identity' => 'required|string|'.(filter_var(@$data["identity"], FILTER_VALIDATE_EMAIL) ? 'email' : ''),
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateStatus(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:users,id',
            'status' => 'required|numeric|in:0,1,2',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateChangePassword(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:users,id',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:users,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateEmail(array $data)
    {
        $validator = Validator::make($data, [
            'email' => 'required|string|' . (filter_var(@$data["identity"], FILTER_VALIDATE_EMAIL) ? 'email' : '')
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateResetPassword(array $data)
    {
        $validator = Validator::make($data, [
            'token' => 'required',
            'email' => 'required|string|exist:users,email',
            'password' => 'required',
            'confirm_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}