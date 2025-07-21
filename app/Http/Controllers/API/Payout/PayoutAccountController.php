<?php

namespace App\Http\Controllers\API\Payout;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PayoutAccountService;
use Illuminate\Http\Request;

class PayoutAccountController extends Controller
{
    protected $services;

    function __construct(PayoutAccountService $services){
        $this->services = $services;
    }

    public function index(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->getdata($user_id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function show(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $id = $request->id;
            $result = $this->services->getById($id, $user_id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function inactivate(Request $request)
    {
        try {
            $result = $this->services->getinactive();

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function store(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->store($user_id, $request->all());

            return ApiResponse::success([
                "message" => __("message.save_success"),
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
    public function delete(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $id = $request->id;
            $result = $this->services->deleteById($id, $user_id);

            return ApiResponse::success([
                "message" => __("message.delete_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function setPrimary(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $result = $this->services->setprimary($request->input('id'), $userid);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
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
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getprimary(Request $request)
    {
        try {
            $user_id = $request->user()->id;
            $result = $this->services->getprimary($user_id);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }
}
