<?php

namespace App\Src\Services\Spatie;

use App\Models\User;
use App\Src\Base\IBaseService;
use App\Src\Helpers\Utils;
use App\Src\Services\Eloquent\UserService;
use App\Src\Validators\RoleValidator;
use Spatie\Permission\Models\Role;
use Str;

class RoleService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Role $model, RoleValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;

        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();
    }

    public static function getInstance()
    {
        return new static(new Role(), new RoleValidator());
    }

    public function formatResult($model)
    {
        return [];
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getRolesByName(array $data = [])
    {
        $model = $this->model;
        if ($data) {
            $model = $model->whereIn("name", $data);
        }
        
        return $model->oldest("name")->pluck("name", "id")->toArray();
    }

    public function store(array $data)
    {
        $this->validator->validateStore($data);

        $model = $this->model;
        $model->name = Str::slug($data["name"], '-');

        return $model->save();
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
        $model->name = Str::slug($data["name"], '-');

        return $model->save();
    }

    public function deleteById(int $id)
    {
        $model = $this->findById($id);
        
        return $model->delete();
    }

    public function getRolesDoesntHaveUser(User $user)
    {
        return $this->model->whereDoesntHave('users', function($query) use($user){
            $query->where('model_id', $user->id);
        })->get();
    }

    public function assignUserRole(array $data, UserService $userService)
    {
        $this->validator->validateUserRole($data);

        $user = $userService->findById($data["user_id"]);
        $user->assignRole($data["role_id"]);
    }

    public function removeUserRole(array $data, UserService $userService)
    {
        $this->validator->validateUserRole($data);

        $user = $userService->findById($data["user_id"]);
        $user->removeRole($data["role_id"]);
    }

    public function dtIndex() {
        $query = $this->getAll();

        return datatables()->of($query)
                            ->addIndexColumn()
                            ->addColumn('actions', function($row) {
                                $id = $row->id;
                                $actions = "";
                                
                                $actions .= Utils::getActionFor("edit", route('admin.administrator.role.edit', ["id" => $id]));
                                $actions .= Utils::getActionFor("delete", null, 'onclick="deleteConfirm(this)"', ["id" => $id]);
            
                                return $actions;
                            })
                            ->rawColumns(['actions'])
                            ->toJson();
    }

}