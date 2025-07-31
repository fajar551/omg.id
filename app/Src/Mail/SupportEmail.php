<?php

namespace App\Src\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SupportEmail extends Mailable
{
    use Queueable,SerializesModels;
    
    private $data;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data, $status)
    {
        $this->data = $data;
        $this->status = $status;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
       return $this->from(env('MAIL_FROM_ADDRESS', 'noreply@omg.id'))
            ->subject('Invoice Support '. \ucfirst($this->status))
            ->view('emails.support-email', array('data' =>$this->data));
    }
}
