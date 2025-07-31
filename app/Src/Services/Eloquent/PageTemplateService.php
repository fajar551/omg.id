<?php

namespace App\Src\Services\Eloquent;

use App\Models\PageTemplate;
use App\Src\Helpers\Constant;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\PageTemplateValidator;
use Illuminate\Support\Str;

class PageTemplateService {

    protected $model;
    protected $validator;

    public function __construct(PageTemplate $model, PageTemplateValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getDataTable(array $params = [])
    {
        $query = $this->getAll();

        return datatables()->of($query)
                ->editColumn('image', function($row) {
                    return route("api.templateimage.preview", ["file_name" => $row->image ?: Constant::UNKNOWN_STATUS]);
                })
                ->editColumn('category', function($row) {
                    return Constant::getTemplateCategory($row->category);
                })
                ->rawColumns([])
                ->toJson();
    }

    public function getDetail(int $id)
    {
        $model = $this->findById($id);

        return $this->formatResult($model);
    }

    public function store(array $data, UploadService $uploadService)
    {
        $this->validator->validateStore($data);
        
        $model = $this->model;
        $model->title = $data["title"];
        $model->category = $data["category"];
        $model->price = $data["price"];
        $model->directory_name = $data["directory_name"];

        $uploadData = [
            "prefix" => "page_template",
            "path" => Constant::TEMPLATE_IMAGE_PATH,
            "file" => @$data["image"],
        ];

        $model->image = $uploadService->upload($uploadData);
        $model->save();

        return $this->formatResult($model);
    }

    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    public function editById(int $id, array $data, UploadService $uploadService)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->title = $data["title"];
        $model->category = $data["category"];
        $model->price = $data["price"];
        $model->directory_name = $data["directory_name"];

        if (isset($data["image"])) {
            $uploadData = [
                "prefix" => "page_template",
                "path" => Constant::TEMPLATE_IMAGE_PATH,
                "file" => @$data["image"],
            ];

            if ($model->image) {
                $uploadData["old_file"] = Constant::TEMPLATE_IMAGE_PATH ."/{$model->image}";
            }

            $model->image = $uploadService->upload($uploadData);
        }

        $model->save();

        return $this->formatResult($model);
    }

    public function deleteById(int $id, UploadService $uploadService)
    {
        $model = $this->findById($id);

        // Delete post file
        $oldFile = Constant::TEMPLATE_IMAGE_PATH ."/{$model->image}";
        $uploadService->delete($oldFile);

        return $model->delete();
    }

    public function setCategory(int $id, int $category)
    {
        $model = $this->findById($id);
        $model->category = $category ? 0 : 1;
        $model->save();

        return [
            "id" => $model->id,
            "category" => Constant::getTemplateCategory($model->category),
        ];
    }

    public function filterByCategory($id)
    {
        $query = $this->model->where("category", $id);

        return datatables()->of($query)
                ->editColumn('image', function($row) {
                    return route("api.templateimage.preview", ["file_name" => $row->image ?: Constant::UNKNOWN_STATUS]);
                })
                ->editColumn('category', function($row) {
                    return Constant::getTemplateCategory($row->category);
                })
                ->rawColumns([])
                ->toJson();
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "title" => $model->title,
            "price" => $model->price,
            "directory_name" => $model->directory_name,
            "image" => route("api.templateimage.preview", ["file_name" => $model->image ?: Constant::UNKNOWN_STATUS]),
            "category" => Constant::getTemplateCategory($model->category),
        ];
    }

    public function preview($filename, UploadService $uploadService)
    {
        return $uploadService->preview(Constant::TEMPLATE_IMAGE_PATH ."/$filename");
    }

}