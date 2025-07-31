<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class PermissionValidator {

    protected $tableNames;

    public function __construct() {
        $this->tableNames = config('permission.table_names');
    }

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|alpha_spaces|max:255|unique:'.$this->tableNames['permissions'].',name',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateBulkStore(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|array',
            'name.*' => 'required|string|alpha_spaces|max:255|unique:'.$this->tableNames['permissions'].',name',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'required|numeric|exists:'.$this->tableNames['permissions'].',id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:'.$this->tableNames['permissions'].',id',
            'name' => 'required|string|alpha_spaces|max:255|unique:'.$this->tableNames['permissions'].',name,'.$data["id"],
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateUserPermission(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:users,id',
            'permission_id' => 'required|array',
            'permission_id.*' => 'numeric|exists:'.$this->tableNames['permissions'].',id',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateDeleteUserPermission(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:users,id',
            'permission_id' => 'required|numeric|exists:'.$this->tableNames['permissions'].',id',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}