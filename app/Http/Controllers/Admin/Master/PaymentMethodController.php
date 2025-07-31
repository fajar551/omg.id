<?php

namespace App\Http\Controllers\Admin\Master;

use App\Http\Controllers\Controller;
use App\Src\Helpers\WebResponse;
use App\Src\Helpers\ApiResponse;
use App\Src\Services\Eloquent\PaymentMethodService;
use App\Src\Services\Upload\UploadService;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{

    protected $service;
    protected $uploadService;

    public function __construct(PaymentMethodService $service, UploadService $uploadService)
    {
        $this->service = $service;
        $this->uploadService = $uploadService;
    }

    public function index()
    {
        try {
            $data = [
                'paymentMethods' => $this->service->getPaymentMethods(),
            ];
    
            return view('admin.master.payment-method.index', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function create()
    {
        try {    
            return view('admin.master.payment-method.create');
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function edit($id)
    {
        try {
            $data = [
                'model' => $this->service->getDetail($id),
            ];
            return view('admin.master.payment-method.edit', $data);
        } catch (\Exception $ex) {
            return WebResponse::error($ex);
        }
    }

    public function update(Request $request)
    {
        try {
            // dd($request->all());
            $this->service->editById($request->id, $request->all(), $this->uploadService);

            return WebResponse::success(__("message.update_success"), 'admin.master.paymentmethod.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.paymentmethod.create');
        }
    }

    public function store(Request $request)
    {
        try {
            // dd($request->all());
            $this->service->store($request->all(), $this->uploadService);

            return WebResponse::success(__("message.save_success"), 'admin.master.paymentmethod.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.paymentmethod.create');
        }
    }

    public function changeIcon(Request $request)
    {
        try {
            $this->service->changeIcon($request->all());

            return WebResponse::success(__("message.update_success"), 'admin.master.paymentmethod.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.paymentmethod.index');
        }
    }

    public function setactive(Request $request)
    {
        try {
            // dd($request->all());
            $result = $this->service->setActive($request->id);

            return WebResponse::success($result['result'], 'admin.master.paymentmethod.index');
        } catch (\Exception $ex) {
            return WebResponse::error($ex, 'admin.master.paymentmethod.create');
        }
    }

}
