<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\ProductPurchase;
use App\Jobs\SendProductPurchaseEmail;
use Illuminate\Support\Facades\Mail;

class TestProductEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:product-email {purchase_id?} {--email=}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test sending product purchase email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $purchaseId = $this->argument('purchase_id');
        $testEmail = $this->option('email');

        if ($purchaseId) {
            // Test specific purchase
            $purchase = ProductPurchase::with(['product.ebook', 'product.ecourse', 'product.digital'])->find($purchaseId);
            
            if (!$purchase) {
                $this->error("❌ Purchase with ID {$purchaseId} not found!");
                return 1;
            }

            $this->info("📧 Testing email for purchase ID: {$purchaseId}");
            $this->info("Product: {$purchase->product->name}");
            $this->info("Type: {$purchase->product->type}");
            $this->info("Buyer: {$purchase->buyer_name} ({$purchase->email})");
            $this->info("Status: {$purchase->status}");

            // Override email if provided
            if ($testEmail) {
                $purchase->email = $testEmail;
                $this->info("📧 Using test email: {$testEmail}");
            }

            // Check if product has file
            $filePath = $this->getProductFilePath($purchase);
            if ($filePath) {
                $this->info("📎 Product file: {$filePath}");
                $this->info("📎 File exists: " . (file_exists($filePath) ? 'Yes' : 'No'));
                if (file_exists($filePath)) {
                    $this->info("📎 File size: " . number_format(filesize($filePath) / 1024, 2) . " KB");
                }
            } else {
                $this->warn("⚠️ No product file found");
            }

            // Send email
            try {
                SendProductPurchaseEmail::dispatch($purchase);
                $this->info("✅ Email job dispatched successfully!");
            } catch (\Exception $e) {
                $this->error("❌ Failed to send email: " . $e->getMessage());
                return 1;
            }

        } else {
            // List recent purchases
            $this->info("📋 Recent product purchases:");
            
            $purchases = ProductPurchase::with(['product'])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();

            if ($purchases->isEmpty()) {
                $this->warn("No purchases found!");
                return 0;
            }

            $headers = ['ID', 'Product', 'Type', 'Buyer', 'Email', 'Status', 'Date'];
            $rows = [];

            foreach ($purchases as $purchase) {
                $rows[] = [
                    $purchase->id,
                    $purchase->product->name,
                    $purchase->product->type,
                    $purchase->buyer_name,
                    $purchase->email,
                    $purchase->status,
                    $purchase->created_at->format('Y-m-d H:i')
                ];
            }

            $this->table($headers, $rows);
            
            $this->info("\n💡 Usage:");
            $this->info("  php artisan test:product-email {purchase_id}");
            $this->info("  php artisan test:product-email {purchase_id} --email=test@example.com");
        }

        return 0;
    }

    /**
     * Get the product file path based on product type
     */
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