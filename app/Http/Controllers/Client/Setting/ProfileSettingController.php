<?php

namespace App\Http\Controllers\Client\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\UserService;
use App\Src\Services\Upload\UploadService;
use Illuminate\Http\Request;
use Auth;

class ProfileSettingController extends Controller {
    
    protected $services; 
    protected $uploadService;

    public function __construct(UserService $services, UploadService $uploadService) {
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function index(Request $request) {
        try {
            $userid = Auth::user()->id;
            $data = $this->services->getProfile($userid);

            return view('client.setting.profile.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function update(Request $request)
    {
        try {
            $data = $request->all();
            $userid = Auth::user()->id;
            
            $this->services->updateProfile($userid, $data, $this->uploadService);

            return WebResponse::success(__("message.update_success"), 'setting.profile.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'setting.profile.index');
        }
    }

    public function updateProfilePicture(Request $request)
    {
        try {
            $data = [
                'profile_picture' => $request->profile_picture
            ];

            $userid = Auth::user()->id;
            $result = $this->services->updateProfilePicture($userid, $data, $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}
