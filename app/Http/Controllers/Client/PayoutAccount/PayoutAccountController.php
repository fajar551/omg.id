<?php

namespace App\Http\Controllers\Client\PayoutAccount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\PayoutAccountService;
use App\Src\Services\Eloquent\PayoutChannelService;
use App\Src\Services\Eloquent\UserBalanceService;

class PayoutAccountController extends Controller {
    
    protected $services; 

    public function __construct(PayoutAccountService $services) {
        $this->services = $services;
    }

    public function index(Request $request)
    {
        try {
            if (auth()->check()==true) {
            $result = $this->services->getdata($request->user()->id);
            }else{
                $result = "You not logged in yet.";
            }
            $balance = UserBalanceService::getInstance()->getById($request->user()->id);
            if ($balance['active']==0 && $balance['pending']==0) {
                return redirect()->route('balance.index');
            }
            $data = [
                "payout_account" => $this->services->getdata($request->user()->id),
                "payout_channel" => PayoutChannelService::getInstance()->getChannel()
            ];

            return view('client.payoutaccount.index', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }

    public function create(Request $request)
    {
        try {
            $userid = $request->user()->id;
            // dd($request->input());
            $this->services->store($userid, $request->input());

            return WebResponse::success(__("message.save_success"), 'payoutaccount.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'payoutaccount.index');
        }
    }

    public function setprimary(Request $request)
    {
        try {
            $userid = $request->user()->id;
            // dd($request->input());
            $this->services->setprimary($request->input("id"), $userid);

            return WebResponse::success(__("message.payout_accout_setprimary"), 'payoutaccount.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'payoutaccount.index');
        }
    }
    
    public function edit(Request $request) {
        try {
            $id = $request->id;
            
            $user_id = $request->user()->id;
            $data = [
                'data' => $this->services->getById($id, $user_id),
            ];

            return view('client.payoutaccount.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'payoutaccount.index');
        }
    }

    public function update(Request $request) {
        try {
            $data = $request->input();

            $this->services->editById($request->input('id'), $data);
            
            return WebResponse::success(__("message.update_success"), 'payoutaccount.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'payoutaccount.edit', ['id' => $request->id]);
        }
    }

    public function delete(Request $request) {
        try {
            $user_id = $request->user()->id;
            $id = $request->input('id');
            // dd($id);
            $this->services->deleteById($id, $user_id);

            return WebResponse::success(__("message.delete_success"), 'payoutaccount.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'payoutaccount.index');
        }
    }

}
