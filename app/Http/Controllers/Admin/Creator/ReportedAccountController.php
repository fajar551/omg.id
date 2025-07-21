<?php

namespace App\Http\Controllers\Admin\Creator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\ReportService;
use Illuminate\Http\Request;

class ReportedAccountController extends Controller
{

    protected $services;

    public function __construct(ReportService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        return view('admin.creator.reported-account.index');
    }


    public function suspend(Request $request)
    {
        try {
            $result = $this->services->suspend($request->id);

            return WebResponse::success($result, 'admin.creator.reportedaccount.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.reportedaccount.index');
        }
    }

    public function unsuspend(Request $request)
    {
        try {
            $result = $this->services->unsuspend($request->id);

            return WebResponse::success($result, 'admin.creator.reportedaccount.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.reportedaccount.index');
        }
    }

    public function getlistcreatorprocess(Request $request)
    {
        return ReportService::getInstance()->getlist(0, 'creator');
    }

    public function getlistcreatordone(Request $request)
    {
        return ReportService::getInstance()->getlist(1, 'creator');
    }

}
