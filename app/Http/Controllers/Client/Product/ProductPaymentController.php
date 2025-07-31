<?php

namespace App\Http\Controllers\Client\Product;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\PaymentMethod;
use App\Src\Services\Midtrans\ProductPaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductPaymentController extends Controller
{
    protected $productPaymentService;

    public function __construct(ProductPaymentService $productPaymentService)
    {
        $this->productPaymentService = $productPaymentService;
    }

    public function processPayment(Request $request)
    {
        try {
            // Debug: Log semua data yang diterima
            \Log::info('Product Payment Request Data:', $request->all());
            
            // Validasi input
            $request->validate([
                'product_id' => 'required|exists:products,id',
                'buyer_name' => 'required|string|max:255',
                'buyer_email' => 'required|email',
                'buyer_address' => 'nullable|string',
                'buyer_message' => 'nullable|string',
                'quantity' => 'required|integer|min:1',
                'product_type' => 'required|string',
                'page_name' => 'required|string',
                'payment_method_id' => 'required|exists:payment_methods,id'
            ]);

            // Siapkan data untuk ProductPaymentService
            $paymentData = [
                'product_id' => $request->product_id,
                'buyer_name' => $request->buyer_name,
                'buyer_email' => $request->buyer_email,
                'buyer_address' => $request->buyer_address,
                'buyer_message' => $request->buyer_message,
                'quantity' => $request->quantity,
                'product_type' => $request->product_type,
                'page_name' => $request->page_name,
                'payment_method_id' => $request->payment_method_id,
                'name' => $request->buyer_name, // Required by validator
                'email' => $request->buyer_email // Required by validator
            ];
            
            // Debug: Log payment data
            \Log::info('Payment Data for ProductPaymentService:', $paymentData);

            // Dapatkan snap token dari Midtrans menggunakan ProductPaymentService
            $result = $this->productPaymentService->getProductSnapToken($paymentData);

            if (is_string($result)) {
                // Error message returned
                return response()->json([
                    'success' => false,
                    'message' => $result
                ], 400);
            }

            return response()->json([
                'success' => true,
                'snap_token' => $result['token'],
                'purchase_id' => $result['param']['product_id'], // Temporary, will be replaced with actual purchase ID
                'order_id' => $result['param']['order_id'] ?? null
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function paymentStatus($purchaseId)
    {
        $purchase = ProductPurchase::findOrFail($purchaseId);
        
        return view('products.payment-status', [
            'purchase' => $purchase
        ]);
    }

    public function webhook(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);

        $orderId = $data['order_id'];
        $status = $data['transaction_status'];
        $fraudStatus = $data['fraud_status'];

        $purchase = ProductPurchase::where('order_id', $orderId)->first();

        if ($purchase) {
            if ($status == 'capture') {
                if ($fraudStatus == 'challenge') {
                    $purchase->status = 'challenge';
                } else if ($fraudStatus == 'accept') {
                    $purchase->status = 'success';
                    
                    // Send email with product file for digital products
                    if (in_array($purchase->product->type, ['ebook', 'ecourse', 'digital'])) {
                        \App\Jobs\SendProductPurchaseEmail::dispatch($purchase);
                    }
                }
            } else if ($status == 'settlement') {
                $purchase->status = 'success';
                
                // Send email with product file for digital products
                if (in_array($purchase->product->type, ['ebook', 'ecourse', 'digital'])) {
                    \App\Jobs\SendProductPurchaseEmail::dispatch($purchase);
                }
            } else if ($status == 'cancel' || $status == 'deny' || $status == 'expire') {
                $purchase->status = 'failed';
            } else if ($status == 'pending') {
                $purchase->status = 'pending';
            }

            $purchase->save();
        }

        return response()->json(['status' => 'OK']);
    }
} 