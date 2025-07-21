<?php

namespace App\Http\Controllers\API\notification;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\NotificationService;

class NotificationController extends Controller {

    protected $services;

    public function __construct(NotificationService $services) {
        $this->services = $services;
    }

    public function get(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $notificationId = $request->input('notify_id');
            $result = $this->services->getNotifications(["userid" => $userid, "notificationId" => $notificationId]);

            return ApiResponse::success([
                "message" => __("message.retrieve_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

    public function markNotification(Request $request)
    {
        try {
            $userid = $request->user()->id;
            $result = $this->services->markNotification([
                "userid" => $userid, 
                'notificationid' => $request->input('id')
            ]);
                
            return ApiResponse::success([
                "message" => __("message.update_success"),
                "data" => $result,
            ]);
        } catch (\Exception $ex) {
            return ApiResponse::error($ex);
        }
    }

}