<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use Illuminate\Http\Request;

class ContentCategoryController extends Controller
{

    public function __construct()
    {

    }

    public function index()
    {
        return view('admin.master.content-category.index');
    }

}
