<?php

namespace App\Src\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PayoutEmail extends Mailable
{
    use Queueable,SerializesModels;
    
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->from(env('MAIL_FROM_ADDRESS', 'noreply@ommg.id'))
                   ->view('emails.payout-email')
                   ->with([
                       "data" => $this->data
                   ]);
    }
}
