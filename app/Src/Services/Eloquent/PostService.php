<?php

namespace App\Src\Services\Eloquent;

use App\Models\Post;
use App\Src\Base\IBaseService;
use App\Src\Helpers\Constant;
use App\Src\Services\Upload\UploadService;
use App\Src\Validators\PostValidator;
use Str;

class PostService implements IBaseService {

    protected $model;
    protected $validator;

    public function __construct(Post $model, PostValidator $validator) {
        $this->model = $model;
        $this->validator = $validator;
    }

    public static function getInstance()
    {
        return new static(new Post(), new PostValidator());
    }

    public function getAll()
    {
        return $this->model->all();
    }

    public function getPosts(int $id)
    {
        return $this->model->where("user_id", $id);
    }

    public function getPublishedPosts(int $id)
    {
        return $this->model
                    ->where("user_id", $id)
                    ->where("status", 1)
                    ->latest()
                    ->paginate(10)
                    ->map(function ($model) {
                        return $this->formatResult($model);
                    });
    }

    public function getDataTablePosts(int $id, array $params = [])
    {
        $query = $this->getPosts($id);

        return datatables()->of($query)
                ->addColumn('creator', function($row) {
                    return $row->user->name;
                })
                ->editColumn('pinned', function($row) {
                    return (bool) $row->pinned;
                })
                ->editColumn('post_image', function($row) {
                    return route("api.post.preview", ["file_name" => $row->post_image ?: Constant::UNKNOWN_STATUS]);
                })
                ->editColumn('status', function($row) {
                    return Constant::getPostStatus($row->status);
                })
                ->orderColumn('creator', function($query, $order) {
                    // TODO: Change order by to name of user instead of id_user
                    $query->orderBy('user_id', $order);
                })
                ->rawColumns([])
                ->toJson();
    }

    public function getDetail(int $id)
    {
        $model = $this->model->with([
                        "comments" => function($q) {
                            $q->oldest();
                        },
                    ])->find($id);

        $data["comments"] = $model->comments->map(function($model) {
            return CommentService::getFormatResult($model);
        });

        return array_merge($data, $this->formatResult($model));
    }

    public function store(int $user_id, array $data, UploadService $uploadService)
    {
        $data["user_id"] = $user_id;
        $this->validator->validateStore($data);
        
        $model = $this->model;
        $model->user_id= $user_id;
        $model->title = ucwords($data["title"]);
        $model->description = $data["description"];
        $model->pinned = @$data["pinned"];
        $model->status = @$data["status"];
        $model->scheduled_at = @$data["scheduled_at"];

        $uploadData = [
            "prefix" => "post",
            "path" => Constant::POST_UPLOAD_PATH,
            "file" => @$data["post_image"],
        ];

        $model->post_image = $uploadService->upload($uploadData);
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
        $model->title = ucwords($data["title"]);
        $model->description = $data["description"];
        $model->pinned = @$data["pinned"];
        $model->status = @$data["status"];
        $model->scheduled_at = @$data["scheduled_at"];

        if (isset($data["post_image"])) {
            $uploadData = [
                "prefix" => "post",
                "path" => Constant::POST_UPLOAD_PATH,
                "file" => @$data["post_image"],
            ];

            if ($model->post_image) {
                $uploadData["old_file"] = Constant::POST_UPLOAD_PATH ."/{$model->post_image}";
            }

            $model->post_image = $uploadService->upload($uploadData);
        }

        $model->save();

        return $this->formatResult($model);
    }

    public function deleteById(int $id, UploadService $uploadService)
    {
        $model = $this->findById($id);

        // Delete post file
        $oldFile = Constant::POST_UPLOAD_PATH ."/{$model->post_image}";
        $uploadService->delete($oldFile);

        return $model->delete();
    }

    public function setPinned(int $id)
    {
        $model = $this->findById($id);
        $model->pinned = $model->pinned ? 0 : 1;
        $model->save();

        return [
            "id" => $model->id,
            "pinned" => (bool) $model->pinned,
        ];
    }

    public function setStatus(int $id, int $status)
    {
        $model = $this->findById($id);
        $model->status = $status;
        $model->save();

        return [
            "id" => $model->id,
            "status" => Constant::getPostStatus($model->status),
        ];
    }

    public function filterByPinned()
    {
        $model = $this->model->where("pinned", 1);

        return $model;
    }

    public function formatResult($model)
    {
        return [
            "id" => $model->id,
            "slug" => Str::slug($model->title, '-').'-'.$model->id,
            "creator" => $model->user->name,
            "title" => $model->title,
            "description" => $model->description,
            "pinned" => (bool) $model->pinned,
            "post_image" => route("api.post.preview", ["file_name" => $model->post_image ?: Constant::UNKNOWN_STATUS]),
            "status" => Constant::getPostStatus($model->status),
            "like_count" => (int) $model->likes->count(),
            "like_by" => $model->likes()->get()->map(function($model) {
                return LikeService::getFormatResult($model);
            }),
            "comment_count" => (int) $model->comments->count(),
            "created_at" => $model->created_at->format("d-m-Y H:i"),
            "updated_at" => $model->updated_at->format("d-m-Y H:i"),
        ];
    }

    public function preview($filename, UploadService $uploadService)
    {
        return $uploadService->preview(Constant::POST_UPLOAD_PATH ."/$filename");
    }

}