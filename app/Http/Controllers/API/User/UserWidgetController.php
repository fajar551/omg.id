<?php

namespace App\Http\Controllers\API\User;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\UserWidgetService;

class UserWidgetController extends Controller {

    protected $services;

    public function __construct(UserWidgetService $services){
        $this->services = $services;
    }

    public function setstreaming(Request $request)
    {
        try {
            $result = $this->services->setstreaming($request->input());

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "result" => $result
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function index()
    {
        try {
            $result = $this->services->getlist();

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "result" => $result
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}