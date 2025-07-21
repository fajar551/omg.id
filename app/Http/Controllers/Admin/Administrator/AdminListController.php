<?php

namespace App\Http\Controllers\Admin\Administrator;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\UserService;
use App\Src\Services\Spatie\PermissionService;
use App\Src\Services\Spatie\RoleService;
use Illuminate\Http\Request;

class AdminListController extends Controller
{

    protected $services;

    public function __construct(UserService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        try {
            $data = [];

            return view('admin.administrator.list.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }
    
    public function create() {
        try {
            $data = [
                'roles' => RoleService::getInstance()->getRolesByName(["admin", "moderator", "developer"]),
                'permissions' => PermissionService::getInstance()->getAll()->pluck("name", "id")->toArray(),
            ];

            return view('admin.administrator.list.create', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.list.index");
        }
    }

    public function store(Request $request) {
        try {
            $this->services->storeAdmin($request->all());

            return WebResponse::success(__("message.save_success"), 'admin.administrator.list.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.list.create");
        }
    }

    public function edit(Request $request) {
        try {
            $data = [
                'model' => $this->services->findById($request->id),
                'roles' => RoleService::getInstance()->getRolesByName(["admin", "moderator", "developer"]),
                'permissions' => PermissionService::getInstance()->getAll()->pluck("name", "id")->toArray(),
            ];

            return view('admin.administrator.list.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.list.index");
        }
    }

    public function update(Request $request) {
        try {
            $this->services->updateAdmin($request->all());

            return WebResponse::success(__("message.update_success"), 'admin.administrator.list.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, "admin.administrator.list.edit", ["id" => $request->id]);
        }
    }

    public function delete(Request $request)
    {
        try {
            $this->services->delete($request->input("userid"));

            return WebResponse::success(__("message.delete_success"), 'admin.administrator.list.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.administrator.list.index');
        }
    }

    public function dtIndex(Request $request)
    {
        $params = $request->input();
        $params["adminid"] = $request->user()->id;

        return $this->services->dtListAdmin($params);
    }

}
