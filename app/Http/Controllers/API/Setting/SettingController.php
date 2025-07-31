<?php

namespace App\Http\Controllers\API\Setting;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\SettingService;

class SettingController extends Controller {

    protected $services;

    public function __construct(SettingService $services) {
        $this->services = $services;
    }

    public function set(Request $request)
    {
        try {
            $settings = $request->input("settings");
            $userid = $request->input("userid");
            $type = $request->input("type");

            $result = [];
            foreach ($settings as $name => $value) {
                $this->services->set($name, $value, $type, $userid);
                $result[$name] = $this->services->get($name, null, $userid);
            }

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
                
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function get(Request $request)
    {
        try {
            $settings = $request->input("settings");
            $userid = $request->input("userid");

            $result = [];
            foreach ($settings as $name) {
                $result[$name] = $this->services->get($name, null, $userid);
            }

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}