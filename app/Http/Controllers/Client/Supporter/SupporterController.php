<?php

namespace App\Http\Controllers\Client\Supporter;

use App\Http\Controllers\Controller;
use App\Src\Exceptions\NotFoundException;
use App\Src\Services\Eloquent\ContentSubscribeService;
use App\Src\Services\Eloquent\FollowersService;
use App\Src\Services\Eloquent\SupportService;
use Illuminate\Http\Request;

class SupporterController extends Controller {

    public function subscribed_content(Request $request) {

        try {
            $userid = $request->user()->id;
            $data = [
                "content" => ContentSubscribeService::getInstance()->subscribeedlist($userid, 10),
            ];
            return view('client.supporter.subscribed-content', $data);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage()); 
            }

            return abort(500, $ex->getMessage()); 
        }
    }

    public function support_history(Request $request) {

        try {
            return view('client.supporter.support-history');
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage()); 
            }

            return abort(500, $ex->getMessage()); 
        }
    }

    public function getlisttransactions(Request $request)
    {
        $userid = $request->user()->id;
        return SupportService::getInstance()->support_history($userid, $request->input('type'));
    }

    public function followed_creator(Request $request) {

        try {
            $userid = $request->user()->id;
            $data = [
                "data" => FollowersService::getInstance()->getFollowingsPage($userid),
            ];
            // dd($data);
            return view('client.supporter.followed-creator', $data);
        } catch (\Exception $ex) {
            if ($ex instanceof NotFoundException) {
                return abort(404, $ex->getMessage()); 
            }

            return abort(500, $ex->getMessage()); 
        }
    }
}