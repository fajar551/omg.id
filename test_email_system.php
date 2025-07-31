<?php

require_once 'vendor/autoload.php';

// Bootstrap Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\ProductPurchase;
use App\Jobs\SendProductPurchaseEmail;

echo "=== EMAIL SYSTEM TESTING ===\n\n";

// 1. Check total purchases
$totalPurchases = ProductPurchase::count();
echo "1. Total purchases in database: {$totalPurchases}\n";

if ($totalPurchases == 0) {
    echo "❌ No purchases found. Cannot test email system.\n";
    exit(1);
}

// 2. Get latest purchase
$latestPurchase = ProductPurchase::with(['product.ebook', 'product.ecourse', 'product.digital'])->latest()->first();
echo "2. Latest purchase details:\n";
echo "   - ID: {$latestPurchase->id}\n";
echo "   - Product: {$latestPurchase->product->name}\n";
echo "   - Type: {$latestPurchase->product->type}\n";
echo "   - Status: {$latestPurchase->status}\n";
echo "   - Buyer: {$latestPurchase->buyer_name} ({$latestPurchase->email})\n";
echo "   - Amount: Rp" . number_format($latestPurchase->total_price, 0, ',', '.') . "\n";

// 3. Check if product has file
$filePath = null;
switch ($latestPurchase->product->type) {
    case 'ebook':
        $filePath = $latestPurchase->product->ebook->file_path ?? null;
        break;
    case 'ecourse':
        $filePath = $latestPurchase->product->ecourse->file_path ?? null;
        break;
    case 'digital':
        $filePath = $latestPurchase->product->digital->file_path ?? null;
        break;
}

echo "3. Product file check:\n";
if ($filePath) {
    echo "   - File path: {$filePath}\n";
    echo "   - File exists: " . (file_exists($filePath) ? 'Yes' : 'No') . "\n";
    if (file_exists($filePath)) {
        echo "   - File size: " . number_format(filesize($filePath) / 1024, 2) . " KB\n";
    }
} else {
    echo "   - No file path found for product type: {$latestPurchase->product->type}\n";
}

// 4. Check if purchase is eligible for email
$isEligible = in_array($latestPurchase->product->type, ['ebook', 'ecourse', 'digital']) && $latestPurchase->status === 'success';
echo "4. Email eligibility:\n";
echo "   - Is digital product: " . (in_array($latestPurchase->product->type, ['ebook', 'ecourse', 'digital']) ? 'Yes' : 'No') . "\n";
echo "   - Payment successful: " . ($latestPurchase->status === 'success' ? 'Yes' : 'No') . "\n";
echo "   - Eligible for email: " . ($isEligible ? 'Yes' : 'No') . "\n";

// 5. Test email sending
if ($isEligible) {
    echo "5. Testing email sending:\n";
    try {
        // Override email for testing
        $latestPurchase->email = 'test@example.com';
        
        SendProductPurchaseEmail::dispatch($latestPurchase);
        echo "   ✅ Email job dispatched successfully!\n";
        echo "   📧 Test email will be sent to: test@example.com\n";
    } catch (Exception $e) {
        echo "   ❌ Failed to dispatch email job: " . $e->getMessage() . "\n";
    }
} else {
    echo "5. Skipping email test (not eligible)\n";
}

// 6. Check queue status
echo "6. Queue status:\n";
try {
    $queueSize = \DB::table('jobs')->count();
    echo "   - Jobs in queue: {$queueSize}\n";
    
    $failedJobs = \DB::table('failed_jobs')->count();
    echo "   - Failed jobs: {$failedJobs}\n";
} catch (Exception $e) {
    echo "   - Could not check queue status: " . $e->getMessage() . "\n";
}

// 7. Check log file
echo "7. Log file check:\n";
$logFile = storage_path('logs/laravel.log');
if (file_exists($logFile)) {
    $logSize = filesize($logFile);
    echo "   - Log file exists: Yes\n";
    echo "   - Log file size: " . number_format($logSize / 1024, 2) . " KB\n";
    
    // Check for recent email logs
    $logContent = file_get_contents($logFile);
    $emailLogs = substr_count($logContent, '📧');
    $paymentLogs = substr_count($logContent, '💰');
    $successLogs = substr_count($logContent, '✅');
    $errorLogs = substr_count($logContent, '❌');
    
    echo "   - Email logs (📧): {$emailLogs}\n";
    echo "   - Payment logs (💰): {$paymentLogs}\n";
    echo "   - Success logs (✅): {$successLogs}\n";
    echo "   - Error logs (❌): {$errorLogs}\n";
} else {
    echo "   - Log file does not exist\n";
}

echo "\n=== TESTING COMPLETED ===\n";
echo "\nNext steps:\n";
echo "1. Run: php artisan queue:work\n";
echo "2. Check logs: tail -f storage/logs/laravel.log\n";
echo "3. Check email at: test@example.com\n";
echo "4. Visit: /admin/email-monitoring\n"; 