<?php

namespace App\Src\Services\Eloquent;

use App\Models\Page;
use App\Models\UserInfo;
use App\Src\Validators\UserInfoValidator;

class UserInfoService {

    protected $model;
    protected $validator;
    protected $modelPage;

    public function __construct(UserInfo $model, UserInfoValidator $validator, Page $modelPage){
        $this->model = $model;
        $this->validator = $validator;
        $this->modelPage = $modelPage;
    }

    public function getAll($user_id)
    {
        return $this->model->where('user_id', $user_id)->get();
    }

    public function getById(int $id)
    {
        $model = $this->findById($id);

        return $this->getReturnedValue($model);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function store(int $user_id, array $data)
    {
        $data['user_id'] = $user_id;
        $this->validator->validateStore($data);
        $model = $this->model;
        $model->user_id= $user_id;
        $model->info = $data["info"];
        $model->save();

        return $this->getReturnedValue($model);
    }

    public function editById(int $id, int $user_id,  array $data)
    {
        $data['user_id'] = $user_id;
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->user_id= $user_id;
        $model->info = $data["info"];
        $model->save();
        return $this->getReturnedValue($model);
    }

    public function deleteById($id)
    {
        $model = $this->findById($id);
        return $model->delete();
    }

    public function setactive(int $id, int $user_id)
    {
        $this->validator->validateId($id);

        $this->model->where("user_id", $user_id)->update(array("status" => 0));
        $model = $this->findById($id);
        $model->status = 1;
        $model->save();
        return ["result" => __("message.user_info_activate")];
    }

    public function getactive($page_url)
    {
        $modelPage = $this->modelPage->where('page_url', $page_url)->first();
        return $this->model->where(array('user_id' => $modelPage->user_id, 'status' => 1))->first();
    }

    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "user_id" => $model->user_id,
            "info" => $model->info,
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }
}