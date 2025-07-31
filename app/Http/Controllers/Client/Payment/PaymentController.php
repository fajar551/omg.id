<?php

namespace App\Http\Controllers\Client\Payment;

use App\Http\Controllers\Controller;
use App\Src\Exceptions\NotFoundException;
use App\Src\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Src\Services\Eloquent\SupportService;
use App\Src\Services\Midtrans\PaymentService;

/*
    @Deprecated - use App\Http\Controllers\Client\Support\SupportController
*/
class PaymentController extends Controller {
    protected $supportservice;
    
    public function __construct(SupportService $supportservice) {
        $this->supportservice = $supportservice;
    }

    public function index(Request $request) {
        $order_id=$request->orderID;
        //$result = $this->supportservice->getbyOrderid($order_id);
       // dd($result);
        try {
            $this->supportservice->getbyOrderid($order_id);
            return view('client.payment.index',['orderid' => $order_id ]);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage()); 
            }

            return abort(500, $ex->getMessage()); 
        }
    }

}