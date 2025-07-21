<?php

namespace App\Http\Controllers\API\Page;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use Illuminate\Http\Request;
use App\Src\Services\Eloquent\PageTemplateService;
use App\Src\Services\Upload\UploadService;

class PageTemplateController extends Controller {
    
    protected $services; 
    protected $uploadService;

    public function __construct(
        PageTemplateService $services, 
        UploadService $uploadService) 
    {
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function store(Request $request) {
        try {
            $result = $this->services->store($request->all(), $this->uploadService);

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

    public function getTemplates(Request $request)
    {
        try {
            
            return $this->services->getDataTable();
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function show($id)
    {
        try {
            $result = $this->services->getDetail($id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setCategory(Request $request)
    {
        try {
            $result = $this->services->setCategory($request->id,  $request->category);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }


    public function filterByCategory($id)
    {
        try {
            return $result = $this->services->filterByCategory($id);

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
