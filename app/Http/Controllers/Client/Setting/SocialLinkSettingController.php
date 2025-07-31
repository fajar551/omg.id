<?php

namespace App\Http\Controllers\Client\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\SocialLinkService;
use Illuminate\Http\Request;

class SocialLinkSettingController extends Controller {
    
    protected $services; 

    public function __construct(SocialLinkService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {
            $userid = $request->user()->id;
            $data = $this->services->getSocialLink($userid);

            return view('client.setting.social-link.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function store(Request $request) {
        try {
            $userid = $request->user()->id;
            $data = array_merge($request->input(), ["user_id" => $userid]);

            $this->services->store($data);

            return WebResponse::success(__("message.update_success"), 'setting.social.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'setting.social.index');
        }
    }

}
