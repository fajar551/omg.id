<?php

namespace App\Http\Controllers\Client\Balance;

use App\Exports\TransactionHistoryExport;
use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PayoutAccountService;
use App\Src\Services\Eloquent\UserBalanceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Magarrent\LaravelCurrencyFormatter\Facades\Currency;
use App\Src\Helpers\Utils;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\SettingService;
use Maatwebsite\Excel\Facades\Excel;

class BalanceController extends Controller {
    
    protected $services; 

    public function __construct(UserBalanceService $services) {
        $this->services = $services;
    }

    public function index(Request $request) {
        try {if (auth()->check()==true) {
            $result = $this->services->getById($request->user()->id);
        }else{
            $result = "You not logged in yet.";
        }
        
        $data = [
            "active_amount_rp" => Currency::currency("IDR")->format($result["active"]),
            "pending_amount_rp" => Currency::currency("IDR")->format($result["pending"]),
            "active_amount" => $result["active"],
            "pending_amount" => $result["pending"],
            "payout_account" => $payout_account = PayoutAccountService::getInstance()->getprimary($request->user()->id),
            'jsDateFormat' => Utils::defaultDateFormat(true),
            "is_payout_account_set" => isset($payout_account),
            "payout_fee" => Currency::currency("IDR")->format(SettingService::getInstance()->get('payout_fee') + (SettingService::getInstance()->get('payout_fee')*(SettingService::getInstance()->get('ppn')/100)))
        ];
        

            return view('client.balance.index', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }
    
    public function getlisttransactions(Request $request)
    {
        return UserBalanceService::getInstance()->transaction_history($request->user()->id, $request->input('type'));
    }

    public function exporttransactions(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $file_name = 'Transaction History ('. $data['type']. ') '. $data['start_at']. ' - '.$data['end_at']. '.xlsx';
        // dd($data);
        try {
            return Excel::download(new TransactionHistoryExport($data), $file_name);
        } catch (\Throwable $ex) {
            return WebResponse::error($ex, 'balance.index');
        }
    }

}
