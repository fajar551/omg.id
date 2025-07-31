<?php

namespace App\Http\Controllers\API\Explore;
use App\Http\Controllers\Controller;
use App\Src\Helpers\SendResponse;
use App\Src\Services\Eloquent\ExploreService;
use Illuminate\Http\Request;

class ExploreController extends Controller {
    
    protected $services;

    public function __construct(ExploreService $services) {
        $this->services = $services;
    }

    /**
     * Show index page.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Src\Helpers\SendResponse
     */
    public function index(Request $request)
    {
        try {
            $result = $this->services->explore($request->all());

            return SendResponse::success($result, __("message.retrieve_success"));
        } catch (\Throwable $th) {
            return SendResponse::error([], $th->getMessage(), '', $th);
        }
    }
}
