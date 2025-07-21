<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Spatie\PermissionService;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    protected $services;

    public function __construct(PermissionService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        try {
            $data = [];

            return view('admin.administrator.permission.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function create() {
        try {
            $data = [];

            return view('admin.administrator.permission.create', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.permission.index");
        }
    }

    public function store(Request $request) {
        try {
            $this->services->bulkStore($request->all());

            return WebResponse::success(__("message.save_success"), 'admin.administrator.permission.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.permission.create");
        }
    }

    public function edit(Request $request) {
        try {
            $data = [
                'model' => $this->services->findById($request->id),
            ];

            return view('admin.administrator.permission.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.permission.index");
        }
    }

    public function update(Request $request) {
        try {
            $this->services->editById($request->id, $request->all());

            return WebResponse::success(__("message.update_success"), 'admin.administrator.permission.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.permission.edit", ["id" => $request->id]);
        }
    }

    public function delete(Request $request) {
        try {
            $this->services->deleteById($request->get('id'));

            return WebResponse::success(__("message.delete_success"), 'admin.administrator.permission.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.permission.index");
        }
    }

    public function dtIndex(Request $request)
    {
        $params = $request->input();

        return $this->services->dtIndex($params);
    }

}
