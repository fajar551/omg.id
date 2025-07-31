<?php

namespace App\Http\Controllers\API\Followers;
use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\FollowersService;
use App\Src\Services\Eloquent\PageService;
use Illuminate\Http\Request;

class FollowersController extends Controller {
    
    protected $services;

    public function __construct(FollowersService $services){
        $this->services = $services;
    }

    public function index (Request $request)
    {
        try {
            $user_id = $request->input('user_id');
            $followers_id = $request->user()->id;
            $result = $this->services->follow($user_id, $followers_id);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function detail(Request $request)
    {
        try {
            $pages = PageService::getInstance()->getPage($request->page_url);
            $userid = $pages['user_id'];
            $result = $this->services->getFollowInfo($userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }
}
