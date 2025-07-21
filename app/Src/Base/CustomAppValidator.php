<?php

namespace App\Src\Base;

use Validator;

class CustomAppValidator {

    public static function init() {
        // Custom validation rule for alpha_spaces.
        // This will only accept alpha and spaces. 
        // If you want to accept hyphens use: /^[\pL\s-]+$/u.
        Validator::extend('alpha_spaces', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\pL\s]+$/u', $value); 
        });

        // Custom validation rule for alpha_dash_dot.
        // This will only accept letters, numbers, dashes, underscores and dots.
        Validator::extend('alpha_dash_dot', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[0-9A-Za-z.\-_]+$/u', $value); 
        });

        // Custom validation rule for setting_key_exist.
        // This will validate if setting key exist in config.setting.setting_keys.
        Validator::extend('setting_key_exist', function ($attribute, $value, $parameters, $validator) {
            $settingKeys = array_keys(config("settings.setting_keys"));

            return in_array($attribute, $settingKeys);
        });

        // Custom validation rule for check current password.
        // This will validate if user password equal with current password.
        Validator::extend('equal_current_password', function ($attribute, $value, $parameters, $validator) {
            $userPassword = $validator->getData()['user_password'] ?? null;

            return $userPassword ? \Hash::check($value, $userPassword) : false;
        });
    }

}