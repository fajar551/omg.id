<?php

namespace App\Http\Controllers\API\Report;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\ReportService;
use App\Src\Services\Upload\UploadService;
use Illuminate\Http\Request;

class ReportController extends Controller {
    
    protected $services;
    protected $uploadService; 

    function __construct(ReportService $services, UploadService $uploadService){
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

    public function index(Request $request)
    {
        try {
            $status = $request->query('status');
            $type = $request->query('type');
            $result = $this->services->getlist($status, $type);
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

    public function setstatus(Request $request)
    {
        try {
            $result = $this->services->setstatus($request->input());

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function suspend(Request $request)
    {
        try {
            $result = $this->services->suspend($request->input("user_id"));

            return ApiResponse::success([
                "message" => $result
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function unsuspend(Request $request)
    {
        try {
            $result = $this->services->unsuspend($request->input("user_id"));

            return ApiResponse::success([
                "message" => $result
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
