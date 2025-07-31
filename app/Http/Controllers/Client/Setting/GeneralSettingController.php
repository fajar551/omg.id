<?php

namespace App\Http\Controllers\Client\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Services\Eloquent\WidgetService;
use Illuminate\Http\Request;

class GeneralSettingController extends Controller {
    
    protected $services; 
    protected $widgetService; 

    public function __construct(SettingService $services, WidgetService $widgetService) {
        $this->services = $services;
        $this->widgetService = $widgetService;
    }

    public function index(Request $request) {
        try {
            $userid = $request->user()->id;
            $settingsKeys = [
                'language',
                'allow_new_support',
                'allow_news_and_update',
                'profanity_custom_filter',
                'profanity_by_system',
            ];

            $data = [
                'streamKey' => $this->widgetService->currentStreamKey($userid),
                'settings' => $this->services->getMultiple($settingsKeys, $userid),
            ];

            return view('client.setting.general.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function store(Request $request)
    {
        try {
            $settingsKeys = $request->input("settings");
            $userid = $request->user()->id;
            
            $this->services->setMultiple($settingsKeys, $userid);

            return WebResponse::success(__("message.update_success"), 'setting.general.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'setting.general.index');
        }
    }

    public function renewStreamkey(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $this->widgetService->generateStreamKey($userid);

            return WebResponse::success(__("message.generate_streamkey_success"), 'setting.general.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'setting.general.index');
        }
    }

}
