<?php

namespace App\Http\Controllers\API\Guide;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;

class GuideController extends Controller {

    public function update(Request $request)
    {
        try {
            // dd($request->input("route"));
            \Utils::updateGuide($request->input("route"), $request->user()->id);

            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => [
                    "result" => "updated",
                ],
            ]);

        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        } 
    }

}