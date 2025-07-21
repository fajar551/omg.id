<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DisbursementNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $params;
    private $subject = "";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;

        $status = strtolower($this->params["data"]["status"]);

        if ($status == 'queued' || $status == "pending" || $status == 'processed') {
            $this->subject = __("Disbursement Processed");
        } else if($status == 'completed') {
            $this->subject = __("Disbursement Completed");
        } else if($status == 'failed') {
            $this->subject = __("Disbursement Failed");
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->from(env("MAIL_FROM_ADDRESS", "admin@omg.id"), env("MAIL_FROM_NAME", "OMG.ID")) //param 1 = mail adress, param 2 = name
                    ->subject($this->subject)
                    ->view('emails.payout-email', ['data' => $this->params["data"]]);
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'data' => $this->params["data"],
        ];
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notify_id' => $notifiable->notifications()->latest()->first()->id,
        ];
    }

    public function broadcastType()
    {
        return 'notify.disbursement_request';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel("broadcast.user.{$this->params["notifiable_id"]}")
        ];
    }

}
