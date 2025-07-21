<?php

namespace App\Notifications;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PayoutAccountVerifiedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    private $params;
    private $subject = "Payout Account Verified";

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($params)
    {
        $this->params = $params;
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
                    ->view('emails.payout-account-email', ['data' => $this->params["data"]]);
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
            'payout_account_id' => $this->params["payout_account_id"],
            'user_id' => $this->params["userid"],
            'name' => $this->params["name"],
            'email' => $this->params["email"],
            'status' => $this->params["status"],
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
        return 'notify.payout_account_verified';
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
