<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class WidgetValidator {

    public function validateStore(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'string|required',
            'key' => 'string|required|unique:widgets,key',
            'type' => 'string|required'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:widgets,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

    public function validateUpdate(array $data)
    {
        $validator = Validator::make($data, [
            'id' => 'required|numeric|exists:widgets,id',
            'name' => 'string|required',
            'key' => 'string|required|unique:widgets,key,'.$data["id"],
            'type' => 'string|required'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateWidgetType(array $data)
    {
        $validator = Validator::make($data, [
            'type' => 'required|string|in:overlay,web_embed',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateWidgetKey(array $data)
    {
        $validator = Validator::make($data, [
            'key' => 'required|string|exists:widgets,key',
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateWidgetUpdate(array $data)
    {
        $validationArr = [];
        $validationMessageArr = [];

        $configs = $data['settings'];
        $wKey = $data['key'];
        
        foreach ($configs as $key => $value) {
            $config = config("settings.widget_options.{$wKey}");
            if (array_key_exists($key, $config)) {
                $config = $config[$key];
                $validationArr["settings.$key"] = $config['rules'];
    
                $configMessages = $config['messages'];
                foreach ($configMessages as $key2 => $message) {
                    $validationMessageArr["settings.$key2"] = $message;
                }
            }
        }

        $validator = Validator::make($data, array_merge([
            'userid' => 'numeric|required|exists:users,id',
            'key' => 'required|string|exists:widgets,key',
            'settings' => 'required|array',
            // 'config_key' => 'required|array|in:' .implode(",", array_keys(config("settings.widget.{$data["widget_type"]}")[$data["key"]]) ),
        ], $validationArr), $validationMessageArr);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }
}