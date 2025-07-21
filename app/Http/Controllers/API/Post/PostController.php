<?php

namespace App\Http\Controllers\API\Post;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\CommentService;
use App\Src\Services\Eloquent\LikeService;
use Illuminate\Http\Request;
use App\Src\Services\Eloquent\PostService;
use App\Src\Services\Upload\UploadService;

class PostController extends Controller {
    
    protected $services; 
    protected $uploadService; 
    protected $commentService; 
    protected $likeService; 

    public function __construct(
        PostService $services, 
        UploadService $uploadService, 
        CommentService $commentService, 
        LikeService $likeService) 
    {
        $this->services = $services;
        $this->uploadService = $uploadService;
        $this->commentService = $commentService;
        $this->likeService = $likeService;
    }

    public function store(Request $request) {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->store($user_id, $request->all(), $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function update(Request $request) {
        try {
            $result = $this->services->editById($request->id, $request->all(), $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function delete(Request $request) {
        try {
            $this->services->deleteById($request->id, $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.delete_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getPosts(Request $request)
    {
        try {
            $userid = $request->user()->id;
            
            return $this->services->getDataTablePosts($userid);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function     getPublishedPosts(Request $request)
    {
        try {            
            return $this->services->getPublishedPosts($request->user_id);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getDetail(Request $request)
    {
        try {
            $result = $this->services->getDetail($request->id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setPinned(Request $request)
    {
        try {
            $result = $this->services->setPinned($request->id);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setStatus(Request $request)
    {
        try {
            $result = $this->services->setStatus($request->id, $request->status);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function commentCreate(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $data = array_merge(["user_id" => $userid], $request->all());
            $model = $this->services->findById($data["post_id"]);

            $result = $this->commentService->store($data, $model);

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function commentUpdate(Request $request)
    {
        try {
            $result = $this->commentService->update($request->all());

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function commentDelete(Request $request)
    {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $this->commentService->delete($request->all());

            return ApiResponse::success([
                "message" => __("message.delete_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function commentLike(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $data = [
                "type" => 'comment',
                "user_id" => $userid, 
                "model_id" => $request->comment_id, 
                "comment_id" => $request->comment_id,
            ];
            $model = $this->commentService->findById($data["comment_id"]);
            $result = $this->likeService->like($data, $model);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function like(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $data = [
                "type" => 'post',
                "user_id" => $userid, 
                "model_id" => $request->post_id, 
                "post_id" => $request->post_id,
            ];
            $model = $this->services->findById($data["post_id"]);

            $result = $this->likeService->like($data, $model);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function filterByPinned(Request $request)
    {
        try {
            $result = $this->services->filterByPinned();

            return datatables()->of($result)->toJson();
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function preview(Request $request)
    {
        try {
            return $this->services->preview($request->file_name, $this->uploadService);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }

}
