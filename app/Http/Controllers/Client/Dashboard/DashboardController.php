<?php

namespace App\Http\Controllers\Client\Dashboard;

use App\Http\Controllers\Controller;
use App\Src\Exceptions\NotFoundException;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\SupportService;
use App\Src\Services\Eloquent\UserBalanceService;
use App\Src\Services\Xendit\PayoutService;
use Illuminate\Http\Request;
use Magarrent\LaravelCurrencyFormatter\Facades\Currency;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $serviceBalance;

    public function __construct(UserBalanceService $serviceBalance)
    {
        $this->middleware('auth');
        $this->serviceBalance = $serviceBalance;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        try {
            if (auth()->check()==true) {
                $result = $this->serviceBalance->getById($request->user()->id);
            }else{
                $result = "You not logged in yet.";
            }
            
            $user_id = $request->user()->id;
            $data = [
                "total_amount" => Currency::currency("IDR")->format($result["active"]+$result["pending"]),
                "amount_this_month" => Currency::currency("IDR")->format(SupportService::getInstance()->amountpermonth($user_id)),
                "total_support" => SupportService::getInstance()->totalsupport($user_id),
                "total_payout" => Currency::currency("IDR")->format(PayoutService::getInstance()->totalpayout($user_id))
            ];

            return view('client.dashboard.index', $data);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage()); 
            }

            return abort(500, $ex->getMessage()); 
        }
    }

}
