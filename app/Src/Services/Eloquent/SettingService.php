<?php

namespace App\Src\Services\Eloquent;

use App\Models\Setting;
use App\Src\Base\IBaseService;
use App\Src\Validators\SettingValidator;
use InvalidArgumentException;
use Str;

class SettingService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Setting $model, SettingValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new Setting(), new SettingValidator());
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "name" => $model->name,
            "type" => $model->type,
            "data_type" => $model->data_type,
            "value" => $this->castValue($model->value, $model->data_type),
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }

    public function set($name, $value, $type = 0, $userid = null, $dataType = null)
    {
        $this->validator->validateSetting(["name" => $name, "value" => $value]);

        if (!$dataType) {
            $configs = config("settings.setting_keys.{$name}");
            $dataType = $configs["data_type"] ?? null;
        }

        return $this->model->updateOrCreate(
            ["user_id" => $userid, "name" => Str::slug($name, "_")],
            ['value' => $value, "type" => $type, "data_type" => $dataType ?? $this->castDataType($value)]
        );
    }

    public function get($name, $default = null, $userid = null)
    {
        $model = $this->model->where('name', $name);
        if ($userid) {
            $model->where("user_id", $userid);
        }

        $setting = $model->first();

        if (!$default) {
            $configs = config("settings.setting_keys.{$name}");
            $default = $configs["value"] ?? null;
        }

		return $setting ? $this->castValue($setting->value, $setting->data_type) : $default;
    }

    public function getMultiple($settingKeys, $userid = null)
    {
        if (!is_array($settingKeys)) {
            throw new InvalidArgumentException(__('message.setting_keys_must_be_array'));
        }

        $settings = [];
        foreach ($settingKeys as $name) {
            $settings[$name] = $this->get($name, null, $userid);
        }

        return $settings;
    }

    public function setMultiple($settingKeys, $userid = null)
    {
        $this->validator->validateSettingKey($settingKeys);
        if (!is_array($settingKeys)) {
            throw new InvalidArgumentException(__('message.setting_keys_must_be_array'));
        }

        $settings = [];
        foreach ($settingKeys as $name => $value) {
            $this->set($name, $value, 0, $userid);
            $settings[$name] = $this->get($name, null, $userid);
        }

        return $settings;
    }

    public function castValue($val, $castTo)
    {
        switch ($castTo) {
            case 'int':
            case 'integer':
                return intval($val);
            case 'bool':
            case 'boolean':
                return filter_var($val, FILTER_VALIDATE_BOOLEAN);
            case 'float':
                return floatval($val);
            case 'double':
                return doubleval($val);
            case 'array':
            case 'json':
            case 'object':
                return json_decode($val);
            default:
                return $val;
        }
    }

    public function castDataType($val)
    {
        if (in_array($val, ["0", "1", "on", "off", "yes", "no", "true", "false"]) || is_bool($val)) {
            return "boolean";
        }

        if (is_numeric($val)) {            
            if (is_float($val) || is_numeric($val) && ((float) $val != (int) $val)) {
                return "double";
            } else {
                return "integer";
            }
        }

        if (is_array($val)) {
            return "array";
        }

        if (is_array(json_decode($val))) {
            return "array";
        }

        if (json_decode($val)) {
            return "json";
        }

        return gettype($val);
    }

    public function getById(int $id)
    {
        $model = $this->findById($id);

        return $this->formatResult($model);
    }

    public function findByName($name, $userid = null)
    {
        $model = $this->model->where("name", $name);
        if ($userid) {
            $model->where("user_id", $userid);
        }

        return $model->first();
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

}