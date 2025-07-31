<?php

namespace App\Http\Controllers\Client\Integration;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\SettingService;
use Illuminate\Http\Request;

class CustomIntegrationController extends Controller {
    
    protected $services; 
    protected $integrationName = 'custom_webhook'; 

    public function __construct(SettingService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {
            $userid = $request->user()->id;
            $result = $this->services->get($this->integrationName, null, $userid);
            $data = [
                "url" => $result ? $result->url : null, 
                "status" => $result ? $result->status : null, 
                "template_message" => $result ? $result->template_message : __('message.default_template_message'), 
            ];

            return view('client.integration.custom.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function store(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $settings[$this->integrationName] = json_encode([
                "url" => $request->url,
                "status" => $request->status,
                "template_message" => $request->template_message,
            ]);
            
            $result = $this->services->setMultiple($settings, $userid);

            return WebResponse::success(__("message.save_success"), 'integration.custom.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'integration.custom.index');
        }
    }
}
