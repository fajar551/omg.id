<?php

namespace App\Http\Controllers\Admin\Creator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\ReportService;
use Illuminate\Http\Request;

class ReportedContentController extends Controller
{

    protected $services;
    public function __construct(ReportService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        return view('admin.creator.reported-content.index');
    }

    public function getlistcontentprocess(Request $request)
    {
        return ReportService::getInstance()->getlist(0, 'content');
    }

    public function getlistcontentdone(Request $request)
    {
        return ReportService::getInstance()->getlist(1, 'content');
    }

    public function block(Request $request)
    {
        try {
            $result = $this->services->block($request->id);

            return WebResponse::success($result, 'admin.creator.reportedcontent.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.reportedcontent.index');
        }
    }

    public function unblock(Request $request)
    {
        try {
            $result = $this->services->unblock($request->id);

            return WebResponse::success($result, 'admin.creator.reportedcontent.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.reportedcontent.index');
        }
    }

}
