<?php

namespace App\Src\Services\Eloquent;

use App\Models\MyTemplate;
use App\Src\Validators\MyTemplateValidator;

class MyTemplateService {

    protected $model;
    protected $validator;

    public function __construct(MyTemplate $model, MyTemplateValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public function getAll()
    {
        return $this->model->all();
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

    public function store(array $data)
    {
        $this->validator->validateStore($data);
        $model = $this->model;
        $model->user_id= $data["user_id"];
        $model->template_id= $data["template_id"];
        $model->invoice_id= @$data["invoice_id"];
        $model->save();

        return $this->getReturnedValue($model);
    }

    public function editById(int $id, array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->user_id= $data["user_id"];
        $model->template_id= $data["template_id"];
        $model->invoice_id= @$data["invoice_id"];
        $model->save();
        return $this->getReturnedValue($model);
    }

    public function deleteById($id)
    {
        $model = $this->findById($id);
        return $model->delete();
    }

    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "user_id" => $model->user_id,
            "template_id" => $model->template_id,
            "invoice_id" => $model->invoice_id,
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }
}