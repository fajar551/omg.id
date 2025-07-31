<?php

namespace App\Http\Controllers\API\Invoice;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Midtrans\PaymentService;
use App\Src\Services\Midtrans\ProductPaymentService;
use App\Src\Services\Xendit\PaymentService as XenditPaymentService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{

    protected $services;
    protected $productPaymentService;
    protected $XenditServices;
    protected $modelPaymentMethod;

    public function __construct(
        PaymentService $services,
        ProductPaymentService $productPaymentService,
        XenditPaymentService $XenditServices,
        PaymentMethod $modelPaymentMethod
    ) {
        $this->services = $services;
        $this->productPaymentService = $productPaymentService;
        $this->XenditServices = $XenditServices;
        $this->modelPaymentMethod = $modelPaymentMethod;
    }

    public function midtrans(Request $request)
    {
        try {
            // Check if this is a product payment by order_id prefix
            $order_id = $request->input('order_id');
            
            if (strpos($order_id, 'PRODUCT-') === 0) {
                // This is a product payment
                $result = $this->productPaymentService->handleProductCallback($request->input());
            } else {
                // This is a support/donation payment
                $result = $this->services->callback($request->input());
            }

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