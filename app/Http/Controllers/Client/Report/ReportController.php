<?php

namespace App\Http\Controllers\Client\Report;
use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Services\Eloquent\ReportService;
use App\Src\Services\Upload\UploadService;
use Illuminate\Http\Request;

class ReportController extends Controller {
    
    protected $services;
    protected $uploadService;

    public function __construct(ReportService $services, UploadService $uploadService
    ) {
        $this->services = $services;
        $this->uploadService = $uploadService;
    }

    public function index(Request $request)
    {
        try {
            $data = array(
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'link' => $request->input('link'),
                'type' => $request->input('type'),
                'creator_id' => $request->input('creatorid'),
                'content_id' => $request->input('contentid')
            );
            return view('client.static.report.index', $data);
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return $ex->getMessage();
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $this->services->store($request->all(), $this->uploadService);

            return WebResponse::success(__("message.save_success"), 'report.index');
        } catch (\Exception $ex) {
            // TODO: handle this exception
            return WebResponse::error($ex);
            // \dd($ex);
            // return WebResponse::error($ex, 'report.index');
        }
    }

    public function creatorprocess(Request $request)
    {
        # code...
    }

    public function getlistcreatorprocess(Request $request)
    {
        return $this->services->getlist(0, 'creator');
    }
}