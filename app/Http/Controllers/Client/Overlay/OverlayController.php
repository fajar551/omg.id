<?php

namespace App\Http\Controllers\Client\Overlay;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\Utils;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\GoalService;
use App\Src\Services\Eloquent\ItemService;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Services\Eloquent\WidgetService;
use Illuminate\Http\Request;
use Str;

class OverlayController extends Controller {
    
    protected $services; 
    protected $settingServices; 
    const WIDGET_TYPE = "overlay"; 

    public function __construct(WidgetService $services, SettingService $settingServices) {
        $this->services = $services;
        $this->settingServices = $settingServices;
        $this->services->setWidgetType(self::WIDGET_TYPE);
    }

    public function index(Request $request)
    {
        $key = $request->key ?? 'notification';
        $key = Str::slug($key, '_');

        try {
            $userid = $request->user()->id;

            $widgets = $this->services->getAvailableWidgets();
            $widgetWithSettings = $this->services->getWidgetWithSettings($key, $userid);
            $widgetUrl = $this->services->generateWidgetUrl($key, $userid);
            $widgetUrlIframe = $this->services->generateWidgetUrl($key, $userid, ['iframe' => 1, 'real_data' => 0, 'test' => 1]);
            $getWidgetSettingMap = $this->services->getWidgetSettingMap($key, $userid);
            $widgetTheme = $this->services->getAvailableWidgetsTheme($key);
            $streamKey = $this->services->currentStreamKey($userid);
            $streamData = $this->services->checkValidStreamKey($streamKey);
            $creatorPage = $streamData->user->page ? $streamData->user->page->page_url : $streamData->user->username;

            $items = ItemService::getInstance()->getItems($userid);
            $goals = GoalService::getInstance()->getActiveGoals($userid);

            $data = [
                "streamKey" => $streamKey,
                "url" => $widgetUrl,
                "url_iframe" => $widgetUrlIframe,
                "themes" => $widgetTheme,
                "widgets" => $widgets,
                "widget_with_settings" => $widgetWithSettings,
                "widget_settings_map" => $getWidgetSettingMap,
                "creatorPage" => $creatorPage,
                "isUserItemsExist" => count($items) > 0,
                "isUserGoalExist" => count($goals) > 0,
            ];

            // Condition for media share
            if ($key == 'mediashare') {
                $result = $this->settingServices->get('media_share', null, $userid);
                $data["status"] = $result->status ?? 0;
                $data["max_duration"] = $result->max_duration ?? 60;
                $data["price_per_second"] = $result->price_per_second ?? 100;
            }

            // Condition for notification
            if ($key == 'notification') {
                $data['ntfSounds'] = $this->services->getAvailableNotifSound();
            }

            return view("client.overlay.{$key}.index", $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function update(Request $request) {
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
            
            return WebResponse::success(__("message.update_success"), 'overlay.notification', ['key' => $key]);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'overlay.notification', ['key' => $key]);
        }
    }

    public function updateMediaShare(Request $request)
    {
        try {
            $key = Str::slug($request->key, '_');
            $userid = $request->user()->id;
            $settings['media_share'] = json_encode([
                "status" => $request->status ?? 0,
                "max_duration" => $request->max_duration,
                "price_per_second" => $request->price_per_second,
            ]);
            
            $result = $this->settingServices->setMultiple($settings, $userid);

            return WebResponse::success(__("message.update_success"), 'overlay.notification', ['key' => $key]);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'overlay.notification', ['key' => $key]);
        }
    }

}
