<?php

namespace App\Http\Controllers\Client\Product;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ProductPurchase;
use App\Jobs\SendProductPurchaseEmail;

class ProductPurchaseWebhookController extends Controller
{
    /**
     * Handle Xendit webhook for payment status
     */
    public function xenditWebhook(Request $request)
    {
        $payload = $request->all();
        
        // Log webhook payload
        \Log::info('Xendit Webhook', $payload);
        
        // Find purchase by external_id
        $purchase = ProductPurchase::where('transaction_id', $payload['external_id'] ?? '')->first();
        
        if (!$purchase) {
            return response()->json(['message' => 'Purchase not found'], 404);
        }
        
        // Update payment status based on webhook
        if ($payload['status'] === 'PAID') {
            $purchase->update([
                'status' => 'success'
            ]);
            
            // Send email with product file
            if (in_array($purchase->product->type, ['ebook', 'ecourse', 'digital'])) {
                SendProductPurchaseEmail::dispatch($purchase);
            }
        } elseif ($payload['status'] === 'EXPIRED') {
            $purchase->update([
                'status' => 'failed'
            ]);
        }
        
        return response()->json(['message' => 'Webhook processed successfully']);
    }
    
    /**
     * Handle Midtrans webhook for payment status
     */
    public function midtransWebhook(Request $request)
    {
        $payload = $request->all();
        
        // Log webhook payload
        \Log::info('Midtrans Webhook', $payload);
        
        // Find purchase by order_id
        $purchase = ProductPurchase::where('transaction_id', $payload['order_id'] ?? '')->first();
        
        if (!$purchase) {
            return response()->json(['message' => 'Purchase not found'], 404);
        }
        
        // Update payment status based on webhook
        if ($payload['transaction_status'] === 'settlement' || $payload['transaction_status'] === 'capture') {
            $purchase->update([
                'status' => 'success'
            ]);
            
            // Send email with product file
            if (in_array($purchase->product->type, ['ebook', 'ecourse', 'digital'])) {
                SendProductPurchaseEmail::dispatch($purchase);
            }
        } elseif ($payload['transaction_status'] === 'expire') {
            $purchase->update([
                'status' => 'failed'
            ]);
        }
        
        return response()->json(['message' => 'Webhook processed successfully']);
    }
} 