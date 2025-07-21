<?php

namespace App\Src\Services\Eloquent;

use App\Models\PageCategory;
use App\Src\Helpers\Utils;
use App\Src\Validators\PageCategoryValidator;

class PageCategoryService {

    protected $model;
    protected $validator;

    public function __construct(PageCategory $model, PageCategoryValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance(){
        return new static(new PageCategory(), new PageCategoryValidator());
    }

    public function getAll()
    {
        $category_all = [[
            "id" => 0,
            "title" => "All",
            "created_at"=> "2022-04-07T00:05:55.000000Z",
            "updated_at"=> "2022-04-07T00:05:55.000000Z",
            "deleted_at"=> null
        ]];
        return array_merge($category_all, $this->model->all()->toArray());
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
        $model->title = $data["title"];
        $model->save();

        return $this->getReturnedValue($model);
    }

    public function editById(array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($data['id']);
        $model->title = $data["title"];
        $model->save();
        return $this->getReturnedValue($model);
    }

    public function deleteById($id)
    {
        $model = $this->findById($id);
        return $model->delete();
    }

    public function dtListCategory()
    {
        $query = $this->model->get();

        return datatables()->of($query)
                            ->addIndexColumn()
                            ->addColumn('actions', function($row) {
                                $actions = Utils::getActionFor("edit", null, 'onclick="edit(this)"', ['id' => $row['id']]);
                                $actions .= Utils::getActionFor("delete", null, 'onclick="deleteConfirm(this)"', ['id' => $row['id']]);
            
                                return $actions;
                            })
                            ->rawColumns(['actions'])
                            ->toJson();
    }

    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "title" => $model->title,
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }
}