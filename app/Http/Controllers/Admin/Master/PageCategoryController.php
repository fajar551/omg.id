<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PageCategoryService;
use Illuminate\Http\Request;

class PageCategoryController extends Controller
{

    protected $services;
    public function __construct(PageCategoryService $services)
    {
        $this->services = $services;
    }

    public function index()
    {
        try {
            
            return view('admin.master.page-category.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }

    public function dtlist()
    {
        return $this->services->dtListCategory();
    }

    public function store(Request $request)
    {
        try {
            $this->services->store($request->input());
            return WebResponse::success(__("message.save_success"), 'admin.master.pagecategory.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }
    
    public function edit(Request $request)
    {
        try {
            $this->services->editById($request->input());
            return WebResponse::success(__("message.update_success"), 'admin.master.pagecategory.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }
    
    public function delete(Request $request)
    {
        try {
            $this->services->deleteById($request->input('id'));
            return WebResponse::success(__("message.delete_success"), 'admin.master.pagecategory.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }

}
