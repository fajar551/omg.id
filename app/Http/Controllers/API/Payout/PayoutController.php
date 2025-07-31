<?php

namespace App\Http\Controllers\API\Payout;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Midtrans\PayoutService as MidtransPayoutService;
use App\Src\Services\Xendit\PayoutService;
use Illuminate\Http\Request;

class PayoutController extends Controller
{
    protected $services;
    protected $servicesMidtrans;

    function __construct(PayoutService $services, MidtransPayoutService $servicesMidtrans){
        $this->services = $services;
        $this->servicesMidtrans = $servicesMidtrans;
    }
    public function xenditdisbursement(Request $request)
    {
        try {
            $result = $this->services->disbursement($request->user()->id, $request->input());

            return ApiResponse::success([
                // "message" => __("message.payout_process"),
                "message" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function callback(Request $request)
    {
        try {
            $result = $this->services->callback($request->input());

            return ApiResponse::success([
                "message" => __("message.transaction_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function totalpayout(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->totalpayout($user_id);

            return ApiResponse::success([
                "message" => __("message.transaction_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function history(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->history($user_id);

            return datatables()->of($result)->toJson();

        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function midtranspayout(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $amount = $request->input('amount');
            $result = $this->servicesMidtrans->create($user_id, $amount);

            return $result;
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function callbackmidtrans(Request $request)
    {
        try {
            $result = $this->servicesMidtrans->callback($request->input());

            return ApiResponse::success([
                "message" => __("message.transaction_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }
    
}
