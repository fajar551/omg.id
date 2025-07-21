<?php

namespace App\Http\Controllers\API\Invoice;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Midtrans\PaymentService;
use App\Src\Services\Xendit\PaymentService as XenditPaymentService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{

    protected $services;
    protected $XenditServices;
    protected $modelPaymentMethod;

    public function __construct(
        PaymentService $services,
        XenditPaymentService $XenditServices,
        PaymentMethod $modelPaymentMethod
    ) {
        $this->services = $services;
        $this->XenditServices = $XenditServices;
        $this->modelPaymentMethod = $modelPaymentMethod;
    }

    public function midtrans(Request $request)
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

    public function xenditewallet(Request $request)
    {
        try {
            $result = $this->XenditServices->callbackewallet($request->input());

            return ApiResponse::success([
                "message" => __("message.transaction_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function xenditva(Request $request)
    {
        try {
            $result = $this->XenditServices->callbackva($request->input());

            return ApiResponse::success([
                "message" => __("message.transaction_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }
}