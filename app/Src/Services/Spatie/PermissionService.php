<?php

namespace App\Src\Services\Spatie;

use App\Models\User;
use App\Src\Helpers\Utils;
use App\Src\Services\Eloquent\UserService;
use Spatie\Permission\Models\Permission;
use App\Src\Validators\PermissionValidator;
use Str;

class PermissionService {

    protected $model;
    protected $validator;

    public function __construct(Permission $model, PermissionValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public static function getInstance()
    {
        return new static(new Permission(), new PermissionValidator());
    }

    public function formatResult($model)
    {
        return [];
    }

    public function store(array $data)
    {
        $this->validator->validateStore($data);

        $model = $this->model;
        $model = $model->create(['name' => Str::lower($data["name"])]);

        return $model;
    }

    public function bulkStore(array $data)
    {
        $this->validator->validateBulkStore($data);

        $dataArr = array_map(function($value) {
            return [
                "name" => Str::lower($value), 
                "guard_name" => "web",
                "created_at" => now(),
                "updated_at" => now(),
            ];
        }, array_unique($data["name"]));
        
        $model = $this->model;
        $model = $model->insert($dataArr);

        return $model;
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function editById(int $id, array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->name = Str::lower($data["name"]);

        return $model->save();
    }

    public function deleteById(int $id)
    {
        $model = $this->findById($id);
        
        return $model->delete();
    }

    public function getPermissionsDoesntHaveUser(User $user)
    {
        return $this->model->whereDoesntHave('users', function($query) use($user){
            $query->where('model_id', $user->id);
        })->get();
    }

    public function assignUserPermission(array $data, UserService $userService)
    {
        $this->validator->validateUserPermission($data);

        $user = $userService->findById($data["user_id"]);
        $user->givePermissionTo($data["permission_id"]);
    }

    public function removeUserPermission(array $data, UserService $userService)
    {
        $this->validator->validateDeleteUserPermission($data);

        $user = $userService->findById($data["user_id"]);
        $user->revokePermissionTo($data["permission_id"]);
    }

    public function dtIndex() {
        $query = $this->getAll();

        return datatables()->of($query)
                            ->addIndexColumn()
                            ->editColumn('name', function($row) {
                                return ucwords($row->name);
                            })
                            ->addColumn('actions', function($row) {
                                $id = $row->id;
                                $actions = "";
                                
                                $actions .= Utils::getActionFor("edit", route('admin.administrator.permission.edit', ["id" => $id]));
                                $actions .= Utils::getActionFor("delete", null, 'onclick="deleteConfirm(this)"', ["id" => $id]);
            
                                return $actions;
                            })
                            ->rawColumns(['actions'])
                            ->toJson();
    }

}