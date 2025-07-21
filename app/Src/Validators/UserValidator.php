<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class UserValidator {

    protected $tableNames;

    public function __construct() {
        $this->tableNames = config('permission.table_names');
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

    public function validateBalanceId(int $user_id)
    {
        $validator = Validator::make(["user_id" => $user_id], [
            'user_id' => 'numeric|nullable|unique:user_balances,user_id',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
    
    public function validateUsername(string $username)
    {
        $validator = Validator::make(["username" => $username], [
            'username' => 'required|string|unique:users,username',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateProfile(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required|string|alpha_spaces',
            'username' => 'required|string|alpha_dash|unique:users,username,'.$data["id"],
            'gender' => 'required|string|in:male,female',
            'phone_number' => ['nullable', 'regex:/\+62([ -]?\d+)+/', 'min:11', 'max:20'],
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateProfilePicture(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:users,id',
            'profile_picture' => 'required|base64image|base64mimes:jpg,jpeg,png|base64max:2000',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateStoreAdmin(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|alpha_spaces|max:255',
            'username' => 'required|string|alpha_dash|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'gender' => 'required|string|in:male,female',
            'status' => 'required|numeric|in:0,1',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpg,jpeg,png|max:2000',
            'roles' => 'required|array',
            'roles.*' => 'required|numeric|exists:'.$this->tableNames['roles'].',id',
            'permissions' => 'required|array',
            'permissions.*' => 'required|numeric|exists:'.$this->tableNames['permissions'].',id',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateUpdateAdmin(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required|string|alpha_spaces|max:255',
            'username' => 'required|string|alpha_dash|max:255|unique:users,username,'.$data["id"],
            'email' => 'required|string|email|max:255|unique:users,email,'.$data["id"],
            'password' => isset($data["password"]) ? 'required|string|min:6|confirmed' : 'nullable',
            'gender' => 'required|string|in:male,female',
            'status' => 'required|numeric|in:0,1',
            'address' => 'nullable|string',
            'profile_picture' => isset($data["profile_picture"]) ? 'nullable|image|mimes:jpg,jpeg,png|max:2000' : 'nullable',
            'roles' => 'required|array',
            'roles.*' => 'required|numeric|exists:'.$this->tableNames['roles'].',id',
            'permissions' => 'required|array',
            'permissions.*' => 'required|numeric|exists:'.$this->tableNames['permissions'].',id',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateChangePassword(array $data)
    {
        $userPassword = $data["user_password"];
        $validator = Validator::make($data, [
            'current_password' => 'required|equal_current_password',
            'password' => 'required|min:6|different:current_password|confirmed',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateUpdateSupportPage(array $data)
    {
        $validator = Validator::make($data, [
            'userid' => 'required|numeric|exists:users,id',
            'page_url' => ['required', 'string', 'unique:pages,page_url,'.$data["id"], 'min:3', 'alpha_dash_dot'],
            'page_message' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}