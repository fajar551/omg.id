<?php

namespace App\Src\Services\Eloquent;

use App\Models\Like;
use App\Src\Base\IBaseService;
use App\Src\Validators\LikeValidator;

class LikeService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Like $model, LikeValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    /**
     * Get the instance of class.
     *
     * @return object
     */
    public static function getInstance()
    {
        return new static(new Like(), new LikeValidator());
    }

    /**
     * Get formated or customize result from a model.
     *
     * @return array
     */
    public function formatResult($model)
    {
        return [
            "user_id" => $model->user->id,
            "name" => $model->user->name,
        ];
    }

    /**
     * Get formated or customize result from a model.
     *
     * @return array
     */
    public static function getFormatResult($model)
    {
        return self::getInstance()->formatResult($model);
    }

    /**
     * Find a model by and id.
     *
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function findById($id)
    {
        $this->validator->validateId($id);

        return $this->model->find($id);
    }

    /**
     * Like a model
     * 
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return array
     */
    public function like(array $data, $model)
    {
        $this->validator->validateLike($data);

        $likeExist = $model->likes()->where([
            "model_id" => $data["model_id"], 
            "user_id" => $data["user_id"]
        ])->first();

        // TODO: Add condition for post if post has implemented
        $info = '';
        if (@$data['type'] == 'content') {
            $info = __('message.content');
        } else if (@$data['type'] == 'comment') {
            $info = __('message.comment');
        }

        // If like doesn't exist create new
        if (!$likeExist) {
            $model->likes()->create([
                "user_id" => $data["user_id"],
            ]);

            return [
                'like' => true,
                'status' => __('message.like'),
                'message' => __('message.like_info', ['type' =>  $info]),
            ];
        }

        $model->likes()->where([
            "model_id" => $data["model_id"], 
            "user_id" => $data["user_id"]
        ])->delete();

        return [
            'like' => false,
            'status' => __('message.unlike'),
            'message' => __('message.unlike_info', ['type' =>  $info]),
        ];
    }

}