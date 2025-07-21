<?php

namespace App\Http\Controllers\API\Widget;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\Utils;
use App\Src\Services\Eloquent\WidgetService;
use Illuminate\Http\Request;
use Str;

class OverlayController extends Controller {
    
    protected $services; 
    const WIDGET_TYPE = "overlay"; 

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
            $widgetUrlIframe = $this->services->generateWidgetUrl($key, $userid, ['iframe' => 1, 'real_data' => 0, 'test' => 1]);
            $widgetTheme = $this->services->getAvailableWidgetsTheme($key);
            $streamKey = $this->services->currentStreamKey($userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => [
                    "streamKey" => $streamKey,
                    "url" => $widgetUrl,
                    "url_iframe" => $widgetUrlIframe,
                    "themes" => $widgetTheme,
                    "widgets" => $widgets,
                    "widget_with_settings" => $widgetWithSettings,
                ],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function widgetURL(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $key = Str::slug($request->key, '_');
            $extra = [];
            if ($request->mode == "preview") {
                $extra["test"] = true;
            }

            if (in_array($request->real_data, ["1", "true"])) {
                $extra["real_data"] = true;
            }

            $widgetUrl = $this->services->generateWidgetUrl($key, $userid, $extra);
            $widgetUrlIframe = $this->services->generateWidgetUrl($key, $userid, ['iframe' => 1, 'real_data' => $extra["real_data"] ?? 0, 'test' => 1]);
            $streamKey = $this->services->currentStreamKey($userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => [
                    "streamKey" => $streamKey,
                    "url" => $widgetUrl,
                    "url_iframe" => $widgetUrlIframe,
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

            $data = [
                "userid" => $userid,
                "settings" => $config,
                "key" => $key,
            ];

            $this->services->updateWidgetSetting($data);
            $streamKey = $this->services->currentStreamKey($userid);
            $widgetUrl = $this->services->generateWidgetUrl($key, $userid);
            $widgetUrlIframe = $this->services->generateWidgetUrl($key, $userid, ['iframe' => 1, 'real_data' => 0, 'test' => 1]);
            
            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => [
                    "streamKey" => $streamKey,
                    "url" => $widgetUrl,
                    "url_iframe" => $widgetUrlIframe,
                ],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function renewStreamKey(Request $request)
    {
        try {  
            $userid = $request->user()->id;
            $streamKey = $this->services->generateStreamKey($userid);
            
            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => [
                    "streamKey" => $streamKey,
                ],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function preview(Request $request)
    {
        try {
            $key = $request->key;
            $test = $request->test == 1 || $request->test == "true";
            $realData = $request->real_data == 1 || $request->real_data == "true";
            $data = array_merge([
                "key" => $key, 
                "test" => $test, 
                "realData" => $realData,
                "qParams" => $request->all(),
            ], $request->all());
            //dd($data);
            $streamData = $this->services->checkValidStreamKey($data["streamKey"]);
            $data["creatorPage"] = $streamData->user->page ? $streamData->user->page->page_url : $streamData->user->username;
            $data["user_id"] = $streamData->user->id;
            //dd($data["creatorPage"]);

            if ($themeKey = Utils::findArrayKeyWithPattern("/\w_theme$/", $data)) {
                $theme = $data[$themeKey];

                if (!$theme) {
                    throw new \InvalidArgumentException("Theme not found!");
                }

                return view("widgets.overlay.{$key}.{$theme}", $data);
            }

            return view("widgets.overlay.{$key}", $data);
        } catch (\Exception $ex) {
            return 'An error occured. Please refresh your overlay or resubmit your overlay configuration.';
        }
    }

    public function widgetShow(Request $request)
    {
        try {
            $data = array_merge($request->all(), ["key" => $request->key]);
            $result = $this->services->widgetShow($data);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => [
                    "result" => $result,
                ],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}
