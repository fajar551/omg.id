<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductPurchase;
use App\Jobs\SendProductPurchaseEmail;
use Illuminate\Http\Request;

class EmailMonitoringController extends Controller
{
    public function index()
    {
        $purchases = ProductPurchase::with(['product'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalPurchases = ProductPurchase::count();
        $successfulPayments = ProductPurchase::where('status', 'success')->count();
        $pendingPayments = ProductPurchase::where('status', 'pending')->count();
        $digitalProducts = ProductPurchase::whereHas('product', function($query) {
            $query->whereIn('type', ['ebook', 'ecourse', 'digital']);
        })->where('status', 'success')->count();

        return view('admin.email-monitoring', compact(
            'purchases',
            'totalPurchases',
            'successfulPayments',
            'pendingPayments',
            'digitalProducts'
        ));
    }

    public function testEmail(Request $request, $purchaseId)
    {
        try {
            $purchase = ProductPurchase::with(['product.ebook', 'product.ecourse', 'product.digital'])
                ->findOrFail($purchaseId);

            // Override email for testing
            $testEmail = $request->input('test_email');
            if ($testEmail) {
                $purchase->email = $testEmail;
            }

            // Check if product has file
            $filePath = $this->getProductFilePath($purchase);
            if (!$filePath || !file_exists($filePath)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product file not found or does not exist'
                ]);
            }

            // Send test email
            SendProductPurchaseEmail::dispatch($purchase);

            return response()->json([
                'success' => true,
                'message' => 'Test email sent successfully to ' . $purchase->email
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to send test email: ' . $e->getMessage()
            ]);
        }
    }

    public function logs()
    {
        $logFile = storage_path('logs/laravel.log');
        $logs = [];

        if (file_exists($logFile)) {
            $logContent = file_get_contents($logFile);
            $lines = explode("\n", $logContent);
            
            // Get last 100 lines
            $lines = array_slice($lines, -100);
            
            foreach ($lines as $line) {
                if (strpos($line, '📧') !== false || 
                    strpos($line, '💰') !== false || 
                    strpos($line, '📎') !== false ||
                    strpos($line, '✅') !== false ||
                    strpos($line, '❌') !== false) {
                    $logs[] = $line;
                }
            }
        }

        return view('admin.email-logs', compact('logs'));
    }

    private function getProductFilePath($purchase)
    {
        $product = $purchase->product;
        
        switch ($product->type) {
            case 'ebook':
                return $product->ebook->file_path ?? null;
            case 'ecourse':
                return $product->ecourse->file_path ?? null;
            case 'digital':
                return $product->digital->file_path ?? null;
            default:
                return null;
        }
    }
} 