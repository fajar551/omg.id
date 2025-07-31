<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Src\Services\Midtrans\ProductPaymentService;

class ProductPaymentWebController extends Controller
{
    protected $productPaymentService;

    public function __construct(ProductPaymentService $productPaymentService)
    {
        $this->productPaymentService = $productPaymentService;
    }

    public function checkout(Request $request)
    {
        $result = $this->productPaymentService->getProductSnapToken($request->all());
        $token = $result['token'] ?? null;
        return view('products.snap-checkout', compact('token'));
    }
} 