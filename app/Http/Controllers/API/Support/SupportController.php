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

class SupportController extends Controller
{

    protected $services;
    protected $XenditServices;
    protected $modelPaymentMethod;
    protected $paymentValidator;
    protected $supportservice;

    public function __construct(
        PaymentService $services,
        XenditPaymentService $XenditServices,
        PaymentMethod $modelPaymentMethod,
        PaymentValidator $paymentValidator,
        SupportService $supportservice
    ) {
        $this->services = $services;
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
            // $detailemail = SupportService::getInstance()->getbyOrderid('b353e4ec-9ba0-31ec-9c64-ce56fe01ca88');
            // SendEmailInvoiceJob::dispatch(array('email' => 'tania.hastuti@haryanto.biz', 'data' => $detailemail));
            // \dd($request->input());
            // $this->paymentValidator->validateStore($request->input());
            // $paymentMethod = $this->modelPaymentMethod->find($request->input('payment_method_id'));
            // if ($paymentMethod->bank_name == 'sahabat_sampoerna' || $paymentMethod->payment_type =='ovo' || $paymentMethod->payment_type =='linkaja' || $paymentMethod->payment_type == 'dana') {
                $result = $this->XenditServices->paymentchargenew($request->input());
            // }else{
                // return ApiResponse::error();
                // $result = $this->services->paymentcharge($request->input());
            // }            

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
}

