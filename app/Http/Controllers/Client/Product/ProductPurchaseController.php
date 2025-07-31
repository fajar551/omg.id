<?php

namespace App\Http\Controllers\Client\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\ProductPurchase;
use App\Models\PaymentMethod;
use App\Jobs\SendProductPurchaseEmail;

class ProductPurchaseController extends Controller
{
    public function __construct()
    {
        // Tidak ada middleware auth agar bisa diakses publik
    }

    public function show($pageName, $productId)
    {
        $product = Product::with(['ebook', 'ecourse', 'buku', 'digital'])->find($productId);
        
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        // Get available payment methods
        $paymentMethods = PaymentMethod::where('disabled', null)->orderBy('order', 'ASC')->get();

        return view('products.purchase', compact('product', 'pageName', 'paymentMethods'));
    }

    public function purchase(Request $request, $pageName, $productId)
    {
        $product = Product::find($productId);
        
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

                       $validated = $request->validate([
                   'quantity' => 'required|integer|min:1',
                   'shipping_address' => $product->type === 'buku' ? 'required|string' : 'nullable|string',
                   'email' => 'required|email',
                   'name' => 'required|string',
                   'payment_method_id' => 'required|exists:payment_methods,id',
                   'phone_number' => 'nullable|string',
               ]);

        // Hitung total harga (gunakan custom_amount jika ada, jika tidak gunakan harga produk)
                       $totalPrice = $product->price * $validated['quantity'];

        // Get payment method
        $paymentMethod = PaymentMethod::find($validated['payment_method_id']);
        
        // Buat record pembelian
        $purchase = ProductPurchase::create([
            'user_id' => Auth::id() ?? null, // Bisa null untuk pembelian tanpa login
            'product_id' => $product->id,
            'quantity' => $validated['quantity'],
            'total_price' => $totalPrice,
            'shipping_address' => $validated['shipping_address'] ?? null,
            'buyer_name' => $validated['name'],
            'email' => $validated['email'],
            'custom_amount' => null,
            'status' => 'pending',
            'payment_method' => $paymentMethod->name,
            'payment_status' => 'pending',
        ]);

        // Send email with product file for digital products
        if (in_array($product->type, ['ebook', 'ecourse', 'digital'])) {
            SendProductPurchaseEmail::dispatch($purchase);
        }
        
        // Redirect ke halaman pembayaran
        return redirect()->route('product.payment', ['page_name' => $pageName, 'id' => $purchase->id]);
    }

    public function payment($pageName, $purchaseId)
    {
        $purchase = ProductPurchase::with(['product', 'user'])->find($purchaseId);
        
        if (!$purchase) {
            return redirect()->back()->with('error', 'Pembelian tidak ditemukan.');
        }

        // Jika user login, pastikan hanya bisa akses pembeliannya sendiri
        if (Auth::check() && $purchase->user_id && $purchase->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pembelian ini.');
        }

        return view('products.payment', compact('purchase', 'pageName'));
    }
} 