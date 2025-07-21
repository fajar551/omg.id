<?php

namespace App\Http\Controllers\API\Widget;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\WidgetService;
use Illuminate\Http\Request;
use Str;

class WebEmbedController extends Controller {
    
    protected $services; 
    const WIDGET_TYPE = "web_embed"; 

    public function __construct(WidgetService $services) {
        $this->services = $services;
        $this->services->setWidgetType(self::WIDGET_TYPE);
    }

    public function index(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $key = Str::slug($request->key, '_');
            $widgets = $this->services->getAvailableWidgets();
            $widgetWithSettings = $this->services->getWidgetWithSettings($key, $userid);
            $widgetUrl = $this->services->generateWidgetUrl($key, $userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => [
                    "url" => $widgetUrl,
                    "widgets" => $widgets,
                    "widget_with_settings" => $widgetWithSettings,
                ],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function updateSetting(Request $request) {
        try {
            $userid = $request->user()->id;
            $config = $request->settings;
            $key = Str::slug($request->key, '_');

            foreach ($config as $keyConfig => $value) {
                $this->services->addSetting([
                    "key" => $key,
                    "user_id" => $userid,
                    "name" => $keyConfig,
                    "value" => $value,
                ]);
            }

            $widgetUrl = $this->services->generateWidgetUrl($key, $userid);
            
            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => [
                    "url" => $widgetUrl,
                ],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function preview(Request $request)
    {
        // TODO: Return widget view
        return $request->all();
    }

}
