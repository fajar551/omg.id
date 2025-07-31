<?php

namespace App\Src\Services\Eloquent;

use App\Models\ContentCategory;
use App\Src\Validators\ContentCategoryValidator;

class ContentCategoryService {

    protected $model;
    protected $validator;

    public function __construct(ContentCategory $model, ContentCategoryValidator $validator){
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new ContentCategory(), new ContentCategoryValidator());
    }

    /**
     * Get category content of user.
     *
     * @param int $user_id
     * @return object
     */
    public function getCategory(int $user_id)
    {
        return $this->model->where("user_id", $user_id)->get();
    }

    /**
     * Get default category.
     *
     * @return array
     */
    public function getDefaultCategory()
    {
        return [
            "General",
            "Digital Arts",
            "Photography",
            "Photobook",
            "Cosplay",
            "Free",
            "Paid",
            "Music",
            "Video",
            "News",
            "Science And Tech",
            "Gaming",
            "Love Story",
            "Horor",
        ];
    }

    public function findByName(int $creator_id, string $title)
    {
        return $this->model->where(array("user_id"=> $creator_id, "title"=> $title))->first();
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

    /**
     * Create a new data.
     *
     * @param array $data
     * @return array
     */
    public function store(array $data)
    {
        $this->validator->validateStore($data);

        $model = $this->model;
        $model->user_id= $data['user_id'];
        $model->title = ucwords($data["title"]);
        $model->save();

        return $this->getReturnedValue($model);
    }

    public function editById(int $id, array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($id);
        $model->title = strtolower($data["title"]);
        $model->save();
        return $this->getReturnedValue($model);
    }

    /**
     * Delete a record.
     *
     * @param array $data
     * @return bool
     */
    public function delete(array $data)
    {
        $model = $this->model->where('user_id', $data['user_id'])->find($data['id']);

        return $model->delete();
    }

    public function getReturnedValue ($model)
    {
        return [
            "id" => $model->id,
            "title" => ucwords($model->title),
            "created_at" => $model->created_at,
            "updated_at" => $model->updated_at
        ];
    }
}