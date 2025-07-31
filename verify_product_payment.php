<?php
/**
 * Product Payment Configuration Verification Script
 * 
 * Script ini untuk memverifikasi apakah konfigurasi payment produk sudah benar
 */

echo "🔧 Product Payment Configuration Verification\n";
echo "=============================================\n\n";

// 1. Check Laravel Environment
echo "1. Laravel Environment Check:\n";
echo "   APP_ENV: " . (env('APP_ENV') ?: 'NOT_SET') . "\n";
echo "   APP_DEBUG: " . (env('APP_DEBUG') ?: 'NOT_SET') . "\n";
echo "   APP_URL: " . (env('APP_URL') ?: 'NOT_SET') . "\n\n";

// 2. Check Midtrans Configuration
echo "2. Midtrans Configuration Check:\n";
echo "   MIDTRANS_CLIENT_KEY: " . (env('MIDTRANS_CLIENT_KEY') ?: 'NOT_SET') . "\n";
echo "   MIDTRANS_SERVER_KEY: " . (env('MIDTRANS_SERVER_KEY') ?: 'NOT_SET') . "\n";
echo "   MIDTRANS_MERCHANT_ID: " . (env('MIDTRANS_MERCHANT_ID') ?: 'NOT_SET') . "\n\n";

// 3. Check Config Cache
echo "3. Config Cache Check:\n";
$configPath = storage_path('framework/cache/data');
if (file_exists($configPath)) {
    echo "   Config cache exists: YES\n";
} else {
    echo "   Config cache exists: NO\n";
}
echo "\n";

// 4. Check Required Files
echo "4. Required Files Check:\n";
$requiredFiles = [
    'resources/views/products/product-payment-modal.blade.php' => 'Product Payment Modal',
    'app/Http/Controllers/Client/Product/ProductPaymentController.php' => 'Product Payment Controller',
    'app/Src/Services/Midtrans/ProductPaymentService.php' => 'Product Payment Service',
    'config/midtrans.php' => 'Midtrans Config',
    'routes/web.php' => 'Web Routes'
];

foreach ($requiredFiles as $file => $description) {
    if (file_exists($file)) {
        echo "   ✅ {$description}: EXISTS\n";
    } else {
        echo "   ❌ {$description}: MISSING\n";
    }
}
echo "\n";

// 5. Check Routes
echo "5. Routes Check:\n";
$routes = [
    'product.payment.process' => 'Product Payment Process Route'
];

foreach ($routes as $route => $description) {
    try {
        $url = route($route);
        echo "   ✅ {$description}: {$url}\n";
    } catch (Exception $e) {
        echo "   ❌ {$description}: NOT FOUND\n";
    }
}
echo "\n";

// 6. Check Database Tables
echo "6. Database Tables Check:\n";
$requiredTables = [
    'products' => 'Products Table',
    'payment_methods' => 'Payment Methods Table',
    'invoices' => 'Invoices Table',
    'payment_temp' => 'Payment Temp Table'
];

try {
    foreach ($requiredTables as $table => $description) {
        $count = DB::table($table)->count();
        echo "   ✅ {$description}: {$count} records\n";
    }
} catch (Exception $e) {
    echo "   ❌ Database connection failed: " . $e->getMessage() . "\n";
}
echo "\n";

// 7. Check Midtrans Service
echo "7. Midtrans Service Check:\n";
try {
    $midtransConfig = config('midtrans');
    if ($midtransConfig) {
        echo "   ✅ Midtrans config loaded successfully\n";
        echo "   Client Key: " . ($midtransConfig['client_key'] ?: 'NOT_SET') . "\n";
        echo "   Server Key: " . ($midtransConfig['server_key'] ?: 'NOT_SET') . "\n";
        echo "   Is Production: " . ($midtransConfig['is_production'] ? 'YES' : 'NO') . "\n";
    } else {
        echo "   ❌ Midtrans config not loaded\n";
    }
} catch (Exception $e) {
    echo "   ❌ Error loading Midtrans config: " . $e->getMessage() . "\n";
}
echo "\n";

// 8. Recommendations
echo "8. Recommendations:\n";
if (!env('MIDTRANS_CLIENT_KEY')) {
    echo "   ⚠️  Set MIDTRANS_CLIENT_KEY in .env file\n";
}
if (!env('MIDTRANS_SERVER_KEY')) {
    echo "   ⚠️  Set MIDTRANS_SERVER_KEY in .env file\n";
}
if (env('APP_ENV') !== 'production' && env('APP_ENV') !== 'local') {
    echo "   ⚠️  Set APP_ENV to 'local' or 'production' in .env file\n";
}

echo "\n9. Next Steps:\n";
echo "   1. Run: php artisan config:clear\n";
echo "   2. Run: php artisan cache:clear\n";
echo "   3. Test: http://localhost/omg.id-main/public/test-product-snap.html\n";
echo "   4. Check browser console for JavaScript errors\n";
echo "   5. Test product payment flow\n";

echo "\n✅ Verification completed!\n";
?> 