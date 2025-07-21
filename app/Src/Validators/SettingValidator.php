<?php

namespace App\Src\Validators;

use App\Src\Exceptions\ValidatorException;
use App\Src\Exceptions\NotFoundException;
use Validator;

class SettingValidator {

    public function validateSetting(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'value' => 'nullable'
        ]);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateSettingKey(array $data)
    {
        $settingKeys = array_keys(config("settings.setting_keys"));
        $validationArr = [];
        foreach ($data as $key => $value) {
            $configs = config("settings.setting_keys.{$key}");

            $validation = $configs ? explode("|", $configs['rules']) : [];
            $validation[] = 'setting_key_exist';

            $validationArr[$key] = $validation;
        }

        $validator = Validator::make($data, $validationArr);

        if ($validator->fails()) {
            throw new ValidatorException(__("message.validation_failed"), $validator->errors());
        }

        return true;
    }

    public function validateId(int $id)
    {
        $validator = Validator::make(["id" => $id], [
            'id' => 'numeric|required|exists:settings,id',
        ]);

        if ($validator->fails()) {
            throw new NotFoundException(__("message.notfound"), $validator->errors());
        }

        return true;
    }

}