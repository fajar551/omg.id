<?php

namespace App\Http\Controllers\Admin\Creator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use Illuminate\Http\Request;

class PaymentAccountController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.creator.payment-account.index');
    }

}
