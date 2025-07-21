<?php

namespace App\Http\Controllers\API\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Auth\AuthService;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AuthController extends Controller {

    protected $services; 

    /**
     * Using AuthService for all process
     */
    public function __construct(AuthService $services) {
        $this->services = $services;
    }

    /**
     * Auth register user
     * @param  \Illuminate\Http\Request  $request
     * @return Array[
     *  'id' => integer,
     *  'name' => string,
     * ]
     */
    public function register(Request $request) {
        try {
            $result = $this->services->register($request->all());

            return ApiResponse::success([
                "message" => __("message.register_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Auth Login user
     * @param  \Illuminate\Http\Request  $request
     */
    public function login(Request $request) {
        try {
            $result = $this->services->login($request->all());

            return ApiResponse::success([
                "message" => __("message.login_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Auth Logout user
     * @param  \Illuminate\Http\Request  $request
     */
    public function logout(Request $request) {
        try {
            $this->services->logout();

            return ApiResponse::success([
                "message" => __("message.logout_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Function for changeStatus of user
     * @param  \Illuminate\Http\Request  $request
     */
    public function changeStatus(Request $request) {
        try {
            $result = $this->services->changeStatus($request->all());

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Get detail user login
     */
    public function getUser(Request $request) {
        try {
            $result = $this->services->getUser();

            return ApiResponse::success([
                "message" => "OK!",
                "data" => $result,
                // TODO: Uncomment this if plugin permission has been installed
                // "roles" => $result->getRoleNames(),
                // "permissions" => $result->getPermissionNames(),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Forgot password function
     * @param  \Illuminate\Http\Request  $request
     */
    public function forgotpassword(Request $request)
    {
        try {
            $result = $this->services->forgotpassword($request->all());
            return ApiResponse::success([
                "message" => __("message.request_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Reset password function
     * @param  \Illuminate\Http\Request  $request
     */
    public function resetpassword(Request $request)
    {
        try {
            // dd($request->all());
            $status = Password::reset(
                $request->only('email', 'password', 'password_confirmation', 'token'),
                function ($user) use ($request) {
                    $user->forceFill([
                        'password' => bcrypt($request->password),
                    ])->save();

                    $user->tokens()->delete();

                    event(new PasswordReset($user));
                }
            );

            if ($status == Password::PASSWORD_RESET) {
                return response([
                    'message' => 'Password reset successfully'
                ]);
            }
            return response([
                'message' => __($status)
            ], 500);

            // $result = $this->services->resetpassword($request->all());

            // return ApiResponse::success([
            //     "message" => __("message.save_success"),
            //     "data" => $result,
            // ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}
