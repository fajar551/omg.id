<?php

namespace App\Http\Controllers\API\Page;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Src\Services\Eloquent\PageService;
use App\Src\Services\Upload\UploadService;

class PageController extends Controller {
    
    protected $services; 
    protected $uploadService;

    public function __construct(
        PageService $services, 
        UploadService $uploadService) 
    {
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function store(Request $request) {
        try {
            $result = $this->services->store($request->all());

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setProfile(Request $request) {
        try {
            $result = $this->services->setProfile($request->id, $request->all(), $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

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

    public function index($page_url)
    {
        try {
            // $result = $this->services->getDetail($id);
            // dd($page_id);
            $result = $this->services->getPage($page_url);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setCover(Request $request) {
        try {
            $result = $this->services->setCover($request->all(), $request->user()->page->id, $this->uploadService);

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setVideo(Request $request)
    {
        try {
            $result = $this->services->setVideo($request->input('id'),  $request->input('video'));

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setSummary(Request $request)
    {
        try {
            $result = $this->services->setSummary($request->input('id'), $request->input('summary'));

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setCategory(Request $request)
    {
        try {
            $result = $this->services->setCategory($request->input('id'), $request->input('category_id'));

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setfeatured(Request $request)
    {
        try {
            $result = $this->services->setfeatured($request->input('id'));

            return ApiResponse::success([
                "message" => __("message.update_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setpicked(Request $request)
    {
        try {
            $result = $this->services->setpicked($request->input('id'));

            return ApiResponse::success([
                "message" => __("message.update_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setsensitive(Request $request)
    {
        try {
            $result = $this->services->setsensitive($request->input('id'));

            return ApiResponse::success([
                "message" => __("message.update_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setstatus(Request $request)
    {
        try {
            $result = $this->services->setstatus($request->input('id'));

            return ApiResponse::success([
                "message" => __("message.update_success"),
            ]);
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
    public function previewavatar(Request $request)
    {
        try {
            return $this->services->previewavatar($request->file_name, $this->uploadService);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}
