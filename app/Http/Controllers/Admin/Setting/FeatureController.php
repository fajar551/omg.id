<?php

namespace App\Http\Controllers\Admin\Setting;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\FeatureService;
use Illuminate\Http\Request;

class FeatureController extends Controller
{

    protected $services;
    public function __construct(FeatureService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        try {
            
            return view('admin.setting.feature.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }

    public function dtlist()
    {
        return $this->services->dtListCategory();
    }

    public function store(Request $request)
    {
        try {
            $this->services->store($request->input());
            return WebResponse::success(__("message.save_success"), 'admin.setting.feature.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }
    
    public function edit(Request $request)
    {
        try {
            $this->services->editById($request->input());
            return WebResponse::success(__("message.update_success"), 'admin.setting.feature.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }
    
    public function delete(Request $request)
    {
        try {
            $this->services->deleteById($request->input('id'));
            return WebResponse::success(__("message.delete_success"), 'admin.setting.feature.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }
    
    public function status(Request $request)
    {
        try {
            $this->services->setstatus($request->input('id'));
            return WebResponse::success(__("message.update_success"), 'admin.setting.feature.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }

}
