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
        // Send email with product attachment
        Mail::to($this->purchase->email)
            ->send(new ProductPurchaseMail($this->purchase));
    }
}
