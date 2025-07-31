<?php

namespace App\Http\Controllers\Admin\Transaction;

use App\Exports\TransactionDisbursementExport;
use App\Exports\TransactionSupportExport;
use App\Http\Controllers\Controller;
use App\Src\Helpers\Utils;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\TransactionService;
use App\Src\Services\Eloquent\UserService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class DisbursementController extends Controller
{
    public function index(Request $request)
    {
        try {
            $data = array(
                'jsDateFormat' => Utils::defaultDateFormat(true),
            );
            return view('admin.transaction.disbursement.index', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.transaction.disbursement.index');
        }
    }

    public function dtlist(Request $request)
    {
        return TransactionService::getInstance()->getdisbursement($request->input());
    }

    public function selectSearch(Request $request)
    {
        return UserService::getInstance()->selectSearch($request->input('q'));
    }

    public function totalpayout(Request $request)
    {
        // dd($request->input());
        return TransactionService::getInstance()->totalpayout($request->input());
    }

    public function payoutamount(Request $request)
    {
        return TransactionService::getInstance()->payoutamount($request->input());
    }

    public function platformamount(Request $request)
    {
        return TransactionService::getInstance()->platformamount($request->input());
    }

    public function exportexcel(Request $request)
    {
        // dd($request->input());
        try {
            return Excel::download(new TransactionDisbursementExport($request->input()), 'disbursement.xlsx');
        } catch (\Throwable $ex) {
            return WebResponse::error($ex, 'admin.transaction.disbursement.index');
        }
        
    }
}
