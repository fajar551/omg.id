<?php

namespace App\Http\Controllers\Client\Item;

use App\Http\Controllers\Controller;
use App\Src\Helpers\ApiResponse;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\ItemService;
use App\Src\Services\Upload\UploadService;
use Illuminate\Http\Request;

class ItemController extends Controller {
    
    protected $services;
    protected $uploadService; 

    public function __construct(ItemService $services, UploadService $uploadService) {
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function index(Request $request) {
        try {
            $userid = $request->user()->id;
            $data = [
                "data" => $this->services->getItems($userid)
            ];

            return view('client.item.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function create(Request $request) {
        try {
            $data = [];

            return view('client.item.create', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'item.index');
        }
    }
    
    public function store(Request $request) {
        try {
            $userid = $request->user()->id;
            $params = array_merge($request->all(), ["user_id" => $userid]);
            $result = $this->services->store($params, $this->uploadService);

            return WebResponse::success(__("message.save_success"), 'item.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'item.create');
        }
    }

    public function delete(Request $request) {
        try {
            $user_id = $request->user()->id;
            $id = $request->input('id');
            $result = $this->services->deleteById($id, $user_id, $this->uploadService);

            return WebResponse::success(__("message.delete_success"), 'item.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'item.index');
        }
    }

    public function setactive(Request $request) {
        try {
            $user_id = $request->user()->id;
            $id = $request->input('id');
            $result = $this->services->setActiveItem($user_id, $id);

            return WebResponse::success($result['result'] , 'item.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'item.index');
        }
    }

    public function edit(Request $request) {
        try {
            $userid = $request->user()->id;
            $itemid = $request->id;
            
            $data = [
                'model' => $this->services->getUserItem($userid, $itemid),
            ];

            return view('client.item.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'item.index');
        }
    }

    public function update(Request $request) {
        try {
            $userid = $request->user()->id;
            $result = $this->services->editById($request->id, $request->all(), $this->uploadService);

            return WebResponse::success(__("message.update_success"), 'item.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'item.edit', ["id" => $request->id]);
        }
    }

    public function changeicon(Request $request)
    {
        try {
            $this->services->changeIcon($request->all());
            return WebResponse::success(__("message.update_success"), 'item.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'item.index');
        }
    }

}
