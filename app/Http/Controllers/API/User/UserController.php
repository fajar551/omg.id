<?php

namespace App\Http\Controllers\API\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Exceptions\ValidatorException;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\UserService;
use App\Src\Services\Upload\UploadService;

class UserController extends Controller {

    protected $services;
    protected $uploadService;

    public function __construct(UserService $services, UploadService $uploadService){
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function profile(Request $request)
    {
        try {
            $user = $request->user();
            $userid = $user->id;

            /*
            # TODO
            if ($request->userid != $userid) {
                throw new ValidatorException("Invalid userid", []);
            }
            */

            $result = $this->services->getProfile($userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function updateProfile(Request $request)
    {
        try {
            $user = $request->user();
            $userid = $user->id;
            $result = $this->services->updateProfile($userid, $request->all(), $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function changePassword(Request $request)
    {
        try {
            $user = $request->user();
            $userPassword = $user->password;
            $userid = $user->id;

            $data = array_merge($request->all(), ["userid" => $userid, "user_password" => $userPassword]);
            $this->services->changePassword($data);

            return ApiResponse::success([
                "message" => __("message.change_password_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getSupportPage(Request $request)
    {
        try {
            $user = $request->user();
            $userid = $user->id;
            $result = $this->services->getSupportPage($userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function checkusername(Request $request)
    {
        try {
            $result = $this->services->checkusername($request->username);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function updateSupportPage(Request $request)
    {
        try {
            $user = $request->user();
            $userid = $user->id;

            $data = array_merge($request->all(), ["userid" => $userid]);
            $result = $this->services->updateSupportPage($userid, $data);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function preview(Request $request)
    {
        try {
            return $this->services->preview($request->file_name, $this->uploadService);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }

}