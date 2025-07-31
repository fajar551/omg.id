<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class RoleValidator {

    protected $tableNames;

    public function __construct() {
        $this->tableNames = config('permission.table_names');
    }

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string|unique:'.$this->tableNames['roles'].',name',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'required|numeric|exists:'.$this->tableNames['roles'].',id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:'.$this->tableNames['roles'].',id',
            'name' => 'required|string|unique:'.$this->tableNames['roles'].',name,'.$data["id"],
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateUserRole(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'required|numeric|exists:users,id',
            'role_id' => 'required|numeric|exists:'.$this->tableNames['roles'].',id',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}