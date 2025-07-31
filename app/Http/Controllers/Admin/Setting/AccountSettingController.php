<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use Illuminate\Http\Request;

class AccountSettingController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.setting.account.index');
    }

}
