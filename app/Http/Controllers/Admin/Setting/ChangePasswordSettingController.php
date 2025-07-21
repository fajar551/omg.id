<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\UserService;
use Illuminate\Http\Request;
use Auth;

class ChangePasswordSettingController extends Controller {
    
    protected $services; 

    public function __construct(UserService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {
            $data = [];

            return view('admin.setting.change-password.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = Auth::user();
            $data = array_merge($request->input(), ["userid" => $user->id, "user_password" => $user->password]);
            
            $this->services->changePassword($data);

            return WebResponse::success(__("message.update_success"), 'admin.setting.changepw.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.setting.changepw.index');
        }

    }

}
