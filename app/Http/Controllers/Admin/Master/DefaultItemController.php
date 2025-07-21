<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\ItemService;
use App\Src\Services\Upload\UploadService;
use Illuminate\Http\Request;

class DefaultItemController extends Controller
{
    protected $services;
    protected $uploadService;

    public function __construct(ItemService $services, UploadService $uploadService)
    {
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        try {
            $data = [
                'data' => $this->services->getDefaultItems(),
            ];
            return view('admin.master.default-item.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function update($id)
    {
        try {
            $data = [
                'model' => $this->services->getDetail($id),
            ];
            return view('admin.master.default-item.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function edit(Request $request)
    {
        try {
            $this->services->editById($request->id, $request->all(), $this->uploadService);
            return WebResponse::success(__("message.update_success"), 'admin.master.defaultitem.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.defaultitem.update', array('id' => $request->id));
        }
    }

    public function delete(Request $request)
    {
        try {
            $this->services->delete($request->input('id'), $this->uploadService);
            return WebResponse::success(__("message.delete_success"), 'admin.master.defaultitem.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.defaultitem.index');
        }
    }
    public function create(Request $request)
    {
        try {
            $this->services->store_admin($request->all(), $this->uploadService);
            return WebResponse::success(__("message.save_success"), 'admin.master.defaultitem.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.defaultitem.index');
        }
    }

    public function changeicon(Request $request)
    {
        try {
            $this->services->changeIcon($request->all());
            return WebResponse::success(__("message.update_success"), 'admin.master.defaultitem.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.defaultitem.index');
        }
    }

}
