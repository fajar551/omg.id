<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\SettingService;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{

    protected $services; 

    public function __construct(SettingService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        $settingsKeys = [
            'qris',
            'gopay',
            'platform_fee',
            'dana',
            'ovo',
            'linkaja',
            'bank_transfer',
            'shopeepay',
            'payout_fee',
            'ppn',
            'cc_percent',
            'cc_rp'
        ];

        $data = [
            'settings' => $this->services->getMultiple($settingsKeys),
        ];

        return view('admin.setting.system.index', $data);
    }

    public function storePaymentFee(Request $request)
    {
        try {
            $settingsKeys = $request->input("settings");

            $this->services->setMultiple($settingsKeys);

            return WebResponse::success(__("message.update_success"), 'admin.setting.system.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.setting.system.index');
        }
    }

}
