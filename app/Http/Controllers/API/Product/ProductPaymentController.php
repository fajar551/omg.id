<?php

namespace App\Http\Controllers\API\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Src\Services\Midtrans\ProductPaymentService;
use App\Src\Helpers\ApiResponse;

class ProductPaymentController extends Controller
{
    protected $productPaymentService;

    public function __construct(ProductPaymentService $productPaymentService)
    {
        $this->productPaymentService = $productPaymentService;
    }

    public function paymentcharge(Request $request)
    {
        \DB::beginTransaction();
        try {
            $result = $this->productPaymentService->getProductSnapToken($request->input());
            \DB::commit();
            return ApiResponse::success([
                "message" => __("message.transaction_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return ApiResponse::error($ex);
        }
    }
} 