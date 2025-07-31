<?php

namespace App\Http\Controllers\Client\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\UserService;
use Illuminate\Http\Request;

class SupportPageSettingController extends Controller {
    
    protected $services; 

    public function __construct(UserService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {
            $userid = $request->user()->id;
            $data = $this->services->getSupportPage($userid);
            $data = $data['support_page'];

            return view('client.setting.support-page.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function store(Request $request)
    {
        try {
            $userid = $request->user()->id;

            $data = array_merge($request->input(), ["userid" => $userid]);
            $this->services->updateSupportPage($userid, $data);

            return WebResponse::success(__("message.update_success"), 'setting.supportpage.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'setting.supportpage.index');
        }
    }

}
