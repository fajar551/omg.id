<?php

namespace App\Http\Controllers\API\SocialLink;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\SocialLinkService;
use Illuminate\Http\Request;

class SocialLinkController extends Controller {
    
    protected $services; 

    public function __construct(SocialLinkService $services) {
        $this->services = $services;
    }

    public function store(Request $request) {
        try {
            $userid = $request->user()->id;
            $data = array_merge($request->all(), ["user_id" => $userid]);

            $result = $this->services->store($data);

            return ApiResponse::success([
                "message" => __("message.save_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function getSocialLink(Request $request) {
        try {
            $userid = $request->user_id;
            $result = $this->services->getSocialLink($userid);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}
