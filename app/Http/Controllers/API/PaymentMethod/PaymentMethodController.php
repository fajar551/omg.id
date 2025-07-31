<?php

namespace App\Http\Controllers\API\PaymentMethod;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PaymentMethodService;
use Illuminate\Http\Request;
use App\Src\Services\Upload\UploadService;

class PaymentMethodController extends Controller {
    
    protected $services; 
    protected $uploadService; 

    public function __construct(
        PaymentMethodService $services, 
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

    public function index()
    {
        try {
            $result = $this->services->getList();

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result, 
            ]);
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

    public function preview(Request $request)
    {
        try {
            return $this->services->preview($request->file_name, $this->uploadService);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }

}
