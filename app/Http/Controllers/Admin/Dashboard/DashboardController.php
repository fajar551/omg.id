<?php

namespace App\Http\Controllers\Admin\Dashboard;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\Utils;
use App\Src\Services\Eloquent\SupportService;
use App\Src\Services\Eloquent\TransactionService;
use App\Src\Services\Eloquent\UserService;
use App\Src\Services\Midtrans\PayoutService;
use App\Src\Services\Xendit\PaymentService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        try {
            $iris_balance = PayoutService::getInstance()->check_balance();
            // $iris_balance['balance'] = 0;
            $xendit_balance = PaymentService::getInstance()->check_balance();
            $data = array(
                'total_creator' => UserService::getInstance()->total_creator(),
                'total_creator_today' => UserService::getInstance()->total_creator(['today'=>now()->format('Y-m-d')]),
                'total_support' => SupportService::getInstance()->totalsupport(),
                'total_support_today' => SupportService::getInstance()->total_support_today(['today'=>now()->format('Y-m-d')]),
                'total_sold_products' => TransactionService::getInstance()->totalsoldproducts(),
                'total_sold_products_today' => TransactionService::getInstance()->totalsoldproducts_today(),
                'platform_amount' => TransactionService::getInstance()->platformamount(),
                'iris_balance' => Utils::toIDR($iris_balance['balance'] ?? 0),
                'xendit_balance' => Utils::toIDR($xendit_balance['balance'])
            );
            return view('admin.dashboard.index', $data);
        } catch (\Throwable $ex) {
            // dd($ex);
            return WebResponse::error($ex);
        }
    }

    public function totalsoldproductsperdays(Request $request)
    {
        return TransactionService::getInstance()->totalsoldproductsperdays(null, $request->input('filter'));
    }

}
