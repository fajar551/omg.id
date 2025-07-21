<?php

namespace App\Http\Controllers\API\UserBalance;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\UserBalanceService;

class UserBalanceController extends Controller {
    protected $services;

    public function __construct(
        UserBalanceService $services
    ){
        $this->services = $services;
    }

    public function show(Request $request)
    {
        try {
            $result = $this->services->getById($request->user()->id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}