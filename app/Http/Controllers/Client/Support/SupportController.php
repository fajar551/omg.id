<?php

namespace App\Http\Controllers\Client\Support;

use App\Http\Controllers\Controller;
use App\Src\Exceptions\NotFoundException;
use Illuminate\Http\Request;
use App\Src\Services\Eloquent\SupportService;

class SupportController extends Controller {
    
    protected $services;
    protected $filterRoute = [
        "client",
        "clients",
        "admin",
        "admins",
        "home",
        "dashboard",
        "term-of-service",
        "term-of-police",
        "report",
        "login",
        "register",
        "logout",
    ]; 

    public function __construct(SupportService $services) {
        $this->services= $services;
    }

    public function index(Request $request) {
        !in_array($request->page_name, $this->filterRoute) ?: abort(404);

        try {
            $data = $this->services->getPageData([
                "page_name" => $request->page_name,
                "supporter_id" => auth()->check() ? $request->user()->id : null
            ], 'support_page');

            return view('client.support.index', $data);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage()); 
            }

            return abort(500, $ex->getMessage()); 
        }
    }

    public function paymentStatus(Request $request)
    {
        try {
            $order_id = $request->orderID;
            $this->services->getbyOrderid($order_id);

            return view('client.support.payment-status', ['orderid' => $order_id ]);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage()); 
            }

            return abort(500, $ex->getMessage()); 
        }
    }

}
