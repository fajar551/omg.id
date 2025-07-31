<?php

namespace App\Http\Controllers\API\Support;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Midtrans\PaymentService;
use App\Src\Services\Xendit\PaymentService as XenditPaymentService;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Src\Jobs\SendEmailInvoiceJob;
use App\Src\Services\Eloquent\SupportService;
use App\Src\Services\Eloquent\TransactionService;
use App\Src\Validators\PaymentValidator;
use App\Src\Services\Midtrans\ProductPaymentService;

class SupportController extends Controller
{

    protected $services;
    protected $XenditServices;
    protected $modelPaymentMethod;
    protected $paymentValidator;
    protected $supportservice;
    protected $productPaymentService;

    public function __construct(
        PaymentService $services,
        ProductPaymentService $productPaymentService,
        XenditPaymentService $XenditServices,
        PaymentMethod $modelPaymentMethod,
        PaymentValidator $paymentValidator,
        SupportService $supportservice
    ) {
        $this->services = $services;
        $this->productPaymentService = $productPaymentService;
        $this->XenditServices = $XenditServices;
        $this->modelPaymentMethod = $modelPaymentMethod;
        $this->paymentValidator = $paymentValidator;
        $this->supportservice = $supportservice;
    }
    public function show(Request $request)
    {
        \DB::beginTransaction();
        try {
            $result = $this->services->getSnapToken($request->input());

            \DB::commit();
            return $result;
            // return ApiResponse::success([
            //     // "message" => __("message.retrieve_success"),
            //     "data" => $result,
            // ]);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return ApiResponse::error($ex);
        }
    }

    public function snapcharge(Request $request)
    {
        \DB::beginTransaction();
        try {
            $result = $this->services->snapcharge($request->input());

            \DB::commit();
            return $result;
            // return ApiResponse::success([
            //     // "message" => __("message.retrieve_success"),
            //     "data" => $result,
            // ]);
        } catch (\Exception $ex) {
            \DB::rollBack();
            return ApiResponse::error($ex);
        }
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

    public function gethistory(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $result = $this->supportservice->getbyuserid($user_id, $request->all());

            return datatables()->of($result)->toJson();
            // return ApiResponse::success([
            //     "message" => __("message.retrieve_success"),
            //     "data" => $result,
            // ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getdetail(Request $request)
    {
        try {
            $order_id = $request->input('order_id');
            $result = $this->supportservice->getbyOrderid($order_id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function historypage ($creator_id)
    {
        try {
            $result = $this->supportservice->historypage($creator_id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function totalcountperdays(Request $request)
    {
        $user_id = $request->user()->id;
        return TransactionService::getInstance()->totalcountperdays($user_id, $request->input('filter'));
    }

    public function totalamountperdays(Request $request)
    {
        $user_id = $request->user()->id;
        return TransactionService::getInstance()->totalamountperdays($user_id, $request->input('filter'));
    }

    public function platformamountperdays(Request $request)
    {
        return TransactionService::getInstance()->platformamountperdays($request->input('filter'));
    }

    public function totalsoldproductsperdays(Request $request)
    {
        $user_id = $request->user()->id;
        return TransactionService::getInstance()->totalsoldproductsperdays($user_id, $request->input('filter'));
    }

    public function totalsoldproductsamountperdays(Request $request)
    {
        $user_id = $request->user()->id;
        return TransactionService::getInstance()->totalsoldproductsamountperdays($user_id, $request->input('filter'));
    }
}

