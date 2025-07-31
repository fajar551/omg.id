<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\PaymentMethod;

echo "=== PAYMENT METHODS CHECK ===\n\n";

$paymentMethods = PaymentMethod::all();

if ($paymentMethods->count() == 0) {
    echo "❌ Tidak ada payment methods yang ditemukan\n";
} else {
    echo "✅ Ditemukan {$paymentMethods->count()} payment methods:\n\n";
    
    foreach ($paymentMethods as $pm) {
        echo "- {$pm->name} ({$pm->payment_type}) - Type: {$pm->type}\n";
    }
}

echo "\n=== END ===\n"; 