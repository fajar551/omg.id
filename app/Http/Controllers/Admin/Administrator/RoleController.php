<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Spatie\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected $services;

    public function __construct(RoleService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        try {
            $data = [];

            return view('admin.administrator.role.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function create() {
        try {
            $data = [];

            return view('admin.administrator.role.create', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.role.index");
        }
    }

    public function store(Request $request) {
        try {
            $this->services->store($request->all());

            return WebResponse::success(__("message.save_success"), 'admin.administrator.role.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.role.create");
        }
    }

    public function edit(Request $request) {
        try {
            $data = [
                'model' => $this->services->findById($request->id),
            ];

            return view('admin.administrator.role.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.role.index");
        }
    }

    public function update(Request $request) {
        try {
            $this->services->editById($request->id, $request->all());

            return WebResponse::success(__("message.update_success"), 'admin.administrator.role.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.role.edit", ["id" => $request->id]);
        }
    }

    public function delete(Request $request) {
        try {
            $this->services->deleteById($request->get('id'));

            return WebResponse::success(__("message.delete_success"), 'admin.administrator.role.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.role.index");
        }
    }

    public function dtIndex(Request $request)
    {
        $params = $request->input();

        return $this->services->dtIndex($params);
    }

}
