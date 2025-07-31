<?php

namespace App\Http\Controllers\API\Content;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\ContentCategoryService;

class ContentCategoryController extends Controller {
    protected $services;

    /**
     * Use ContentCategoryService for all process
     */
    public function __construct(
        ContentCategoryService $services
    ){
        $this->services = $services;
    }

    /**
     * Get list category by user_id
     * @param  \Illuminate\Http\Request  $request
     */
    public function index(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $result = $this->services->getCategory($userid);

            return datatables()->of($result)->toJson();
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    /**
     * Get list category by user_id
     * 
     * @param  \Illuminate\Http\Request  $request
     */
    public function categories(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $result = $this->services->getCategory($userid);

            return SendResponse::success($result, __('message.retrieve_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

   /**
     * Create a new data.
     *
     * @param array $data
     * @return array
     */
    public function store(Request $request)
    {
        try {
            $request->merge(['user_id' => $request->user()->id]);
            $result = $this->services->store($request->all());

            return SendResponse::success($result, __('message.save_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }

    /**
     * Get detail category by id
     * @param $id
     */
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

    /**
     * Update category
     * @param  \Illuminate\Http\Request  $request
     */
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

    /**
     * Delete a record.
     * 
     * @param \Illuminate\Http\Request $request
     */
    public function delete(Request $request) {
        try {
            $request->merge(['id' => $request->id, 'user_id' => $request->user()->id]);            
            $result = $this->services->delete($request->all());

            return SendResponse::success($result, __('message.delete_success'));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }
}