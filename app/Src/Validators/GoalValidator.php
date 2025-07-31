<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use App\Src\Helpers\Constant;
use App\Src\Helpers\Utils;
use Validator;

class GoalValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|required|min:5|max:100',
            'description' => 'string|nullable|max:191',
            'target' => 'numeric|required|min:50000',
            // 'type' => 'string|required|in:'.implode(",", Constant::GOAL_TYPE),
            'visibility' => 'numeric|required|in:' .implode(",", array_keys(Constant::GOAL_VISIBILITY)),
            'status' => 'required|numeric|in:' .implode(",", array_keys(Constant::GOAL_STATUS)),
            'enable_milestone' => 'nullable|numeric|in:0,1',
            'start_at' => @$data['enable_milestone'] ? 'required|date|date_format:' .Utils::defaultDateFormat() .'|before:end_at' : 'nullable',
            'end_at' => @$data['enable_milestone'] ? 'required|date|date_format:' .Utils::defaultDateFormat() .'|after:start_at' : 'nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:goals,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:goals,id',
            'user_id' => 'numeric|required|exists:users,id',
            'title' => 'string|required|min:5|max:100',
            'description' => 'string|nullable|max:191',
            'target' => 'numeric|required|min:50000',
            // 'type' => 'string|required|in:'.implode(",", Constant::GOAL_TYPE),
            'visibility' => 'numeric|required|in:' .implode(",", array_keys(Constant::GOAL_VISIBILITY)),
            'status' => 'required|numeric|in:' .implode(",", array_keys(Constant::GOAL_STATUS)),
            'enable_milestone' => 'nullable|numeric|in:0,1',
            'start_at' => @$data['enable_milestone'] ? 'required|date|date_format:' .Utils::defaultDateFormat() .'|before:end_at' : 'nullable',
            'end_at' => @$data['enable_milestone'] ? 'required|date|date_format:' .Utils::defaultDateFormat() .'|after:start_at' : 'nullable',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

}