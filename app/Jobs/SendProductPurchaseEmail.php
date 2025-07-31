<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\ProductPurchaseMail;
use App\Models\ProductPurchase;

class SendProductPurchaseEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $purchase;

    /**
     * Create a new job instance.
     */
    public function __construct(ProductPurchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Log email sending attempt
            \Log::info('📧 Attempting to send product purchase email', [
                'purchase_id' => $this->purchase->id,
                'product_name' => $this->purchase->product->name,
                'product_type' => $this->purchase->product->type,
                'buyer_email' => $this->purchase->email,
                'buyer_name' => $this->purchase->buyer_name,
                'total_price' => $this->purchase->total_price,
                'status' => $this->purchase->status
            ]);

            // Check if product has file
            $filePath = $this->getProductFilePath();
            if ($filePath) {
                \Log::info('📎 Product file found', [
                    'file_path' => $filePath,
                    'file_exists' => file_exists($filePath),
                    'file_size' => file_exists($filePath) ? filesize($filePath) : 'N/A'
                ]);
            } else {
                \Log::warning('⚠️ No product file found for purchase', [
                    'purchase_id' => $this->purchase->id,
                    'product_type' => $this->purchase->product->type
                ]);
            }

            // Send email with product attachment
            Mail::to($this->purchase->email)
                ->send(new ProductPurchaseMail($this->purchase));

            // Log successful email sending
            \Log::info('✅ Product purchase email sent successfully', [
                'purchase_id' => $this->purchase->id,
                'buyer_email' => $this->purchase->email
            ]);

        } catch (\Exception $e) {
            // Log email sending error
            \Log::error('❌ Failed to send product purchase email', [
                'purchase_id' => $this->purchase->id,
                'buyer_email' => $this->purchase->email,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            // Re-throw the exception to mark job as failed
            throw $e;
        }
    }

    /**
     * Get the product file path based on product type
     */
    private function getProductFilePath()
    {
        $product = $this->purchase->product;
        
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
