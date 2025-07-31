<?php

namespace App\Http\Controllers\API\Item;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\ItemService;
use Illuminate\Http\Request;
use App\Src\Services\Upload\UploadService;

class ItemController extends Controller {
    
    protected $services; 
    protected $uploadService; 

    public function __construct(
        ItemService $services, 
        UploadService $uploadService) 
    {
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function store(Request $request) {
        try {
            $userid = $request->user()->id;
            $params = array_merge($request->all(), ["user_id" => $userid]);
            $result = $this->services->store($params, $this->uploadService);

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
            $user_id = $request->user()->id;
            $id = $request->id;
            $this->services->deleteById($id, $user_id, $this->uploadService);
            
            return ApiResponse::success([
                "message" => __("message.delete_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getItems(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $result = $this->services->getItems($userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result, 
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getActiveItems(Request $request)
    {
        try {
            $result = $this->services->getActiveItems($request->user_id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result, 
            ]);
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

    public function setActiveItem(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $result = $this->services->setActiveItem($userid, $request->id);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
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

}
