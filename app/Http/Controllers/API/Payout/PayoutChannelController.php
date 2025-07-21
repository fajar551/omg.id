<?php

namespace App\Http\Controllers\API\Payout;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PayoutChannelService;

class PayoutChannelController extends Controller {
    protected $services;

    public function __construct(
        PayoutChannelService $services
    ){
        $this->services = $services;
    }

    public function index()
    {
        try {
            $result = $this->services->getAll();

            return datatables()->of($result)->toJson();
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $result = $this->services->store($request->all());

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function show($id)
    {
        try {
            $result = $this->services->getById($id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getchannel()
    {
        try {
            $result = $this->services->getChannel();

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function update(Request $request)
    {
        try {
            $result = $this->services->editById($request->id, $request->all());

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
            $this->services->deleteById($id);

            return ApiResponse::success([
                "message" => __("message.delete_success"),
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }
}