<?php

namespace App\Http\Controllers\Admin\Creator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PayoutAccountService;
use Illuminate\Http\Request;

class PayoutAccountController extends Controller
{

    protected $services;

    public function __construct(PayoutAccountService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        try {
            
            $data = [
                "inactive_account" => $this->services->getinactive(),
                "active_account" => $this->services->getactive(),
            ];
            // dd($data);
            return view('admin.creator.payout-account.index', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
        
    }

    public function setverified(Request $request)
    {
        try {
            // dd($request->input());
            $this->services->setstatus($request->input("id"));

            return WebResponse::success(__("message.payout_accout_setactive"), 'admin.creator.payoutaccount.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.creator.payoutaccount.index');
        }
    }

}
