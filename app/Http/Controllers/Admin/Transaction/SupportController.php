<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Exports\TransactionSupportExport;
use App\Http\Controllers\Controller;
use App\Src\Helpers\Utils;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\TransactionService;
use App\Src\Services\Eloquent\UserService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SupportController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = array(
                'jsDateFormat' => Utils::defaultDateFormat(true),
            );
            return view('admin.transaction.support.index', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.transaction.support.index');
        }
    }

    public function dtlist(Request $request)
    {
        return TransactionService::getInstance()->getsupports($request->input());
    }

    public function selectSearch(Request $request)
    {
        return UserService::getInstance()->selectSearch($request->input('q'));
    }

    public function totalsupport(Request $request)
    {
        // dd($request->input());
        return TransactionService::getInstance()->totalsupport($request->input());
    }

    public function creatoramount(Request $request)
    {
        return TransactionService::getInstance()->amountpermonth($request->input());
    }

    public function platformamount(Request $request)
    {
        return TransactionService::getInstance()->platformamount($request->input());
    }

    public function exportexcel(Request $request)
    {
        // dd($request->input());
        try {
            return Excel::download(new TransactionSupportExport($request->input()), 'support.xlsx');
        } catch (\Throwable $ex) {
            return WebResponse::error($ex, 'admin.transaction.support.index');
        }
        
    }
}
