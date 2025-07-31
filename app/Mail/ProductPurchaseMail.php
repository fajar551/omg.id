<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Queue\SerializesModels;
use App\Models\ProductPurchase;

class ProductPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $purchase;

    /**
     * Create a new message instance.
     */
    public function __construct(ProductPurchase $purchase)
    {
        $this->purchase = $purchase;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Product Purchase - ' . $this->purchase->product->name,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.product-purchase',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        $attachments = [];
        
        // Add product file as attachment based on product type
        if (in_array($this->purchase->product->type, ['ebook', 'ecourse', 'digital'])) {
            $filePath = $this->getProductFilePath();
            
            if ($filePath && file_exists($filePath)) {
                $attachments[] = Attachment::fromPath($filePath)
                    ->as($this->purchase->product->name . '.' . pathinfo($filePath, PATHINFO_EXTENSION))
                    ->withMime('application/octet-stream');
            }
        }
        
        return $attachments;
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
