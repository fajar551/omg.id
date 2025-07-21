<?php

namespace App\Http\Controllers\Client\Payout;

use App\Http\Controllers\Controller;
use App\Src\Services\Xendit\PayoutService as XenditPayoutService;
use Illuminate\Http\Request;
use App\Src\Helpers\WebResponse;
use Illuminate\Support\Facades\Hash;

class PayoutController extends Controller {
    
    protected $XenditPayoutService; 

    public function __construct(XenditPayoutService $XenditPayoutService) {
        $this->XenditPayoutService = $XenditPayoutService;
    }

    public function create(Request $request)
    {
        try {

            if (! Hash::check($request->password, $request->user()->password)) {
                return back()->withErrors([
                    'password' => ['The provided password does not match our records.']
                ]);
            }
            
            $data = array("amount"=> (int) preg_replace('/[^0-9]+/', '', $request->input("amount")));
            $userid = $request->user()->id;
            
            $this->XenditPayoutService->disbursement($userid, $data);

            return WebResponse::success(__("message.payout_process"), 'balance.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'balance.index');
        }
    }

}
