<?php

namespace App\Src\Jobs;

use App\Src\Mail\SupportEmail;
use App\Src\Services\Eloquent\SettingService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendEmailInvoiceJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $details;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details)
    {
        $this->details = $details;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new SupportEmail($this->details['data'], $this->details['status']);
        Mail::to($this->details['email'])->send($email);

        if ($this->details['data']['status'] == 1 && SettingService::getInstance()->get('allow_new_support', null, $this->details['data']['creator_id']) == 1) {
            $this->details['data']['for_creator'] = 1;
            $email = new SupportEmail($this->details['data'], $this->details['status']);
            Mail::to($this->details['data']['creator_email'])->send($email);
        }
    }
}
