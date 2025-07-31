<?php

// Test script untuk mengecek konfigurasi Midtrans
echo "=== MIDTRANS CONFIGURATION TEST ===\n\n";

// Cek environment variables
$required_vars = [
    'MIDTRANS_MERCHAT_ID',
    'MIDTRANS_CLIENT_KEY', 
    'MIDTRANS_SERVER_KEY',
    'MIDTRANS_PAYOUT_KEY',
    'MIDTRANS_PAYOUT_URL',
    'MIDTRANS_APPROVE_KEY'
];

echo "Environment Variables:\n";
foreach ($required_vars as $var) {
    $value = getenv($var);
    if ($value) {
        echo "✅ {$var}: " . substr($value, 0, 10) . "...\n";
    } else {
        echo "❌ {$var}: NOT SET\n";
    }
}

echo "\nConfig Values:\n";
if (file_exists('config/midtrans.php')) {
    $config = require 'config/midtrans.php';
    foreach ($config as $key => $value) {
        if (is_bool($value)) {
            echo "✅ {$key}: " . ($value ? 'true' : 'false') . "\n";
        } else {
            echo "✅ {$key}: " . (empty($value) ? 'NOT SET' : 'SET') . "\n";
        }
    }
} else {
    echo "❌ config/midtrans.php: NOT FOUND\n";
}

echo "\n=== END TEST ===\n"; 