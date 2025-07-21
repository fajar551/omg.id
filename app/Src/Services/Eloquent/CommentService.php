<?php

namespace App\Src\Services\Eloquent;

use App\Models\Comment;
use App\Src\Base\IBaseService;
use App\Src\Validators\CommentValidator;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CommentService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Comment $model, CommentValidator $validator) {
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
        return new static(new Comment(), new CommentValidator());
    }

    /**
     * Get formated or customize result from a model.
     *
     * @return array
     */
    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "body" => $model->body,
            "user" => $model->user->name,
            "like_count" => (int) $model->likes->count(),
            "like_by" => $model->likes()->get()->map(function($model) {
                return LikeService::getFormatResult($model);
            }),
            "created_at" => $model->created_at->format("d-m-Y H:i"),
            "updated_at" => $model->updated_at->format("d-m-Y H:i"),
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
     * Create a new data.
     *
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model
     * @return array
     */
    public function store(array $data, $model)
    {
        $this->validator->validateStore($data);

        $model = $model->comments()->create([
            "user_id" => $data["user_id"],
            "body" => $data["body"],
        ]);

        $model =  $this->model
                    ->with([
                        'user' => function ($q) {
                            $q->select('id', 'name', 'username', 'profile_picture');
                        },
                        'likes.user' => function ($q) {
                            $q->select('id', 'name', 'profile_picture')->take(10);
                        },
                    ])
                    ->withCount('likes')
                    ->find($model->id);

        return $model;
    }

    /**
     * Update a model.
     *
     * @param array $data
     * @return array
     */
    public function update(array $data)
    {
        $this->validator->validateUpdate($data);

        $model = $this->findById($data['id']);
        if ($model->user_id != $data['user_id']) {
            throw new NotFoundHttpException(__('message.notfound'));
        }
        
        $model->body = $data["body"];
        $model->save();

        $model =  $this->model
                    ->with([
                        'user' => function ($q) {
                            $q->select('id', 'name', 'username', 'profile_picture');
                        },
                        'likes.user' => function ($q) {
                            $q->select('id', 'name', 'profile_picture')->take(10);
                        },
                    ])
                    ->withCount('likes')
                    ->find($model->id);

        return $model;
    }

    /**
     * Delete a model by id.
     *
     * @param array $data
     * @return array
     */
    public function delete(array $data)
    {
        $model = $this->findById($data['id']);

        if ($model->user_id != $data['user_id']) {
            throw new NotFoundHttpException(__('message.notfound'));
        }
        
        return $model->delete();
    }

    /**
     * Get list of comments.
     *
     * @param array $data
     * @param \Illuminate\Database\Eloquent\Model
     * @return array
     */
    public function comments(array $data, $model)
    {
        $model = $model->comments();
        $model = $model->with([
                        'user' => function ($q) {
                            $q->select('id', 'name', 'username', 'profile_picture');
                        },
                        'likes.user' => function ($q) {
                            $q->select('id', 'name', 'profile_picture')->take(10);
                        },
                    ])
                    ->withCount('likes')
                    ->latest()
                    ->paginate(5);
        
        return [
            'meta' => $resource = new JsonResource($model),
            'comments' => $resource->collection($model),
        ];
    }

}