<?php

namespace App\Http\Controllers\API\Content;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\ContentService;
use App\Src\Services\Eloquent\CommentService;
use App\Src\Services\Upload\UploadService;
use App\Src\Services\Eloquent\LikeService;

class ContentController extends Controller
{
    protected $services; 
    protected $uploadService; 
    protected $commentService; 
    protected $likeService; 

    /**
     * Using ContentService, UploadService, CommentService and LikeService
     */
    public function __construct(
        ContentService $services,
        UploadService $uploadService,
        CommentService $commentService, 
        LikeService $likeService
    )
    {
        $this->services = $services;
        $this->commentService = $commentService;
        $this->uploadService = $uploadService;
        $this->likeService = $likeService;
    }


    /**
     * Store content data
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $result = $this->services->store($request->user()->id, $request->all(), $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Update content data
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
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

    /**
     * Delete content by id
     * 
     * @param  $id
     * @return \App\Src\Helpers\SendResponse
     */
    public function delete($id) {
        try {
            $this->services->deleteById($id, $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.delete_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Get detail content
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function show(Request $request)
    {
        try {
            $slug = explode('-', $request->slug);
            $content_id = end($slug);
            $result = $this->services->getDetail($content_id, $request->user()->id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Get list content
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function getContents(Request $request)
    {
        try {
            $userid = $request->user()->id;
            return $this->services->getContents($userid);

        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Set category content
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Src\Helpers\SendResponse 
     */
    public function setCategory(Request $request)
    {
        try {
            $result = $this->services->setCategory($request->id, $request->category_id);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Set status content
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Src\Helpers\SendResponse
     */
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

    /**
     * Filter data by category_id
     * @param  $id
     */
    public function filterByCategory($id)
    {
        try {
            $result = $this->services->filterByCategory($id);

            return datatables()->of($result)->toJson();
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Get list content with published status without login
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function getPublishedContent(Request $request)
    {
        try {
            $result = $this->services->getPublished($request->user_id, $request->query('category'), $request->limit);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Get list content with published status with login
     * 
     * @param  \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse 
     */
    public function getPublished(Request $request)
    {
        try {
            $result = $this->services->getPublishedLoged($request->user_id, $request->user()->id, $request->query('category'));
            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Content comment
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function commentCreate(Request $request)
    {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $model = $this->services->findById($request->id);
            $result = $this->commentService->store($request->all(), $model);

            return SendResponse::success($result, __('message.save_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Content comment update
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function commentUpdate(Request $request)
    {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->commentService->update($request->all());

            return SendResponse::success($result, __('message.update_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Delete content comment
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function commentDelete(Request $request)
    {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->commentService->delete($request->all());

            return SendResponse::success($result, __('message.delete_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Like a content comment
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function commentLike(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $model_id = $request->id;
            $data = [
                "type" => 'comment',
                "user_id" => $userid, 
                "model_id" => $model_id, 
                "comment_id" => $model_id,
            ];

            $model = $this->commentService->findById($model_id);
            $result = $this->likeService->like($data, $model);

            return SendResponse::success($result, __('message.update_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Get list of comments.
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function comments(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $model_id = $request->content_id;
            $data = [
                "user_id" => $userid, 
                "model_id" => $model_id, 
                "comment_id" => $model_id,
            ];

            $model = $this->services->findById($model_id);
            $result = $this->commentService->comments($data, $model);

            return SendResponse::success($result, __('message.retrieve_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Like a content
     * 
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function like(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $model_id = $request->id;
            $data = [
                "type" => 'content',
                "user_id" => $userid, 
                "model_id" => $model_id, 
                "content_id" => $model_id,
            ];

            $model = $this->services->findById($model_id);
            $result = $this->likeService->like($data, $model);

            return SendResponse::success($result, __('message.update_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Preview thumbnail content
     * @param  \Illuminate\Http\Request  $request
     */
    public function previewThumbnail(Request $request)
    {
        try {
            return $this->services->previewThumbnail($request->file_name, $this->uploadService);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }

    /**
     * Preview cover content
     * @param  \Illuminate\Http\Request  $request
     */
    public function previewCover(Request $request)
    {
        try {
            return $this->services->previewCover($request->file_name, $this->uploadService);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }
}
