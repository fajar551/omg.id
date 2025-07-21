<?php

namespace App\Http\Controllers\API\Integration;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\SettingService;
use App\Src\Services\Webhook\WebhookService;

class WebhookController extends Controller {

    protected $services;
    protected $settingService;

    public function __construct(WebhookService $services, SettingService $settingService){
        $this->services = $services;
        $this->settingService = $settingService;
    }

    public function webhook(Request $request)
    {
        try {
            $type = $request->input("type");
            $userid = $request->user()->id;

            $data = [
                "userid" => $userid,
                "type" => $type,
                "test" => true,
                "new_tip" => config("settings.default_new_tip")
            ];

            $result = $this->services->send($data);

            return ApiResponse::success([
                "message" => __("message.webhook_success"),
                "data" => [
                    "result" => $result,
                ],
            ]);

        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }

    // Only for test custom webhook - deleted soon
    public function customWebhook(Request $request)
    {
        try {
            $settingService = \App\Src\Services\Eloquent\SettingService::getInstance();
            $settingService->set("custom-webhook-payloads-test", json_encode($request->input()));

            return ApiResponse::success([
                "message" => __("message.webhook_success"),
                "data" => $settingService->get("custom-webhook-payloads-test"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }

    public function switchStatus(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $status = $request->state;
            $integrationName = $request->key;
            
            $result = $this->settingService->get($integrationName, null, $userid);
            $result->status = $status;
            
            $settings[$integrationName] = json_encode([
                "url" => $result->url,
                "status" => $result->status,
                "template_message" => $result->template_message,
            ]);
            
            $result = $this->settingService->setMultiple($settings, $userid);
            
            return ApiResponse::success([
                "message" => $status ? __("message.webhook_on") : __("message.webhook_off"),
                "status" => $status,
                "data" => [
                    "result" => $result,
                ],
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}