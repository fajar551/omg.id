<?php

namespace App\Http\Controllers\Client\Content;

use App\Http\Controllers\Controller;
use App\Src\Helpers\SendResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\EditorJS\EditorJSUploader;
use App\Src\Services\EditorJS\MetaFetcher;
use App\Src\Services\Eloquent\ContentCategoryService;
use App\Src\Services\Eloquent\ContentService;
use App\Src\Services\Eloquent\ItemService;
use App\Src\Services\Upload\UploadService;
use DOMDocument;
use Illuminate\Http\Request;

class ContentController extends Controller {
    
    protected $services;
    protected $categoryServices;

    public function __construct(ContentService $services, ContentCategoryService $categoryServices) {
        $this->services = $services;
        $this->categoryServices = $categoryServices;
    }
    
    /**
     * Show index page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function index(Request $request) {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->userContents($user_id);
            $activeItem = ItemService::getInstance()->getActiveItems($user_id)[0];

            return view('client.content.index', [
                'data' => $result, 
                'activeItem' => $activeItem
            ]);
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Show create page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function create(Request $request) {
        try {
            $user_id = $request->user()->id;
            $categories = $this->categoryServices->getCategory($user_id);
            $activeItem = @ItemService::getInstance()->getActiveItems($user_id)[0];

            return view('client.content.create', [
                'defaultCategory' => $this->categoryServices->getDefaultCategory(),
                'categories' => $categories,
                'activeItem' => $activeItem,
            ]);
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), route('content.index'), $th);
        }
    }

    /**
     * Create a new data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function store(Request $request) {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->services->store2($request->all());

            return SendResponse::success($result, __('message.save_success'), route('content.index'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), route('content.create'), $th);
        }
    }

    /**
     * Show edit page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function edit(Request $request) {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->showUserContent([
                'id' => $request->id,
                'user_id' => $user_id,
            ]);
            $categories = $this->categoryServices->getCategory($user_id);
            $activeItem = @ItemService::getInstance()->getActiveItems($user_id)[0];

            return view('client.content.edit', [
                'content' => $result,
                'defaultCategory' => $this->categoryServices->getDefaultCategory(),
                'categories' => $categories,
                'activeItem' => $activeItem,
            ]);
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), route('content.index'), $th);
        }
    }

    /**
     * Update an existing data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function update(Request $request) {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->services->update($request->all());

            return SendResponse::success($result, __('message.update_success'), route('content.index'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), route('content.edit', ['id' => $request->id]), $th);
        }
    }

    /**
     * Delete an existing data.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function delete(Request $request) {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->services->delete($request->all());

            return SendResponse::success($result, __('message.delete_success'), route('content.index'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), route('content.index'), $th);
        }
    }
    
    /**
     * Set the status of content to Draft or Publish
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    public function setStatus(Request $request)
    {
        try {
            $result = $this->services->setStatus($request->id, $request->status);

            return SendResponse::success($result, __('message.update_success'), route('content.index'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), route('content.index'), $th);
        }
    }

    /**
     * Download the file attachment.
     * 
     * @param \Illuminate\Http\Request $request
     * @return 
     */
    public function download(Request $request)
    {
        try {
            $request->merge(['user_id' => $request->user()->id, 'id' => $request->id]);

            return $this->services->download($request->all());
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), route('content.edit', ['id' => $request->id]), $th);
        }
    }

    /**
     * get meta data from any url.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function meta(Request $request) 
    {
        try {
            return MetaFetcher::fetch($request->url);
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Handle upload image by file for editor.js.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function upload(Request $request)
    {
        try {
            return EditorJSUploader::upload($request->all());
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Handle upload image by url for editor.js.
     *
     * @param array $data
     * @return \Illuminate\Http\JsonResponse
     */
    public function fetchImage(Request $request)
    {
        try {
            return EditorJSUploader::fetchImage($request->all());
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }
}
