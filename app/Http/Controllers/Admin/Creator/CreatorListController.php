<?php

namespace App\Http\Controllers\Admin\Creator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PageService;
use App\Src\Services\Eloquent\UserService;
use Illuminate\Http\Request;

class CreatorListController extends Controller
{

    protected $services;

    public function __construct(UserService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        return view('admin.creator.list.index');
    }

    public function dtListCreator(Request $request)
    {
        return $this->services->dtListCreator($request->input());
    }

    public function suspend(Request $request)
    {
        try {
            $result = $this->services->suspend($request->id);

            return WebResponse::success($result, 'admin.creator.list.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.list.index');
        }
    }

    public function unsuspend(Request $request)
    {
        try {
            $result = $this->services->unsuspend($request->id);

            return WebResponse::success($result, 'admin.creator.list.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.list.index');
        }
    }

    public function setpicked(Request $request)
    {
        try {
            PageService::getInstance()->setpicked($request->id);

            return WebResponse::success(__("message.update_success"), 'admin.creator.list.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.list.index');
        }
    }

    public function setfeatured(Request $request)
    {
        try {
            PageService::getInstance()->setfeatured($request->id);

            return WebResponse::success(__("message.update_success"), 'admin.creator.list.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex, 'admin.creator.list.index');
        }
    }
}
