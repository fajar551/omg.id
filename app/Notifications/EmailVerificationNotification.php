<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;

class EmailVerificationNotification extends VerifyEmail implements ShouldQueue
{
    use Queueable;

    private $params;
    private $subject = "Verify Email Address";

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
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $this->params["url"] = $this->verificationUrl($notifiable);

        return (new MailMessage)
                    ->from(env("MAIL_FROM_ADDRESS", "admin@omg.id"), env("MAIL_FROM_NAME", "OMG.ID")) //param 1 = mail adress, param 2 = name
                    ->subject($this->subject)
                    ->view('emails.email-verification', $this->params);
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
            //
        ];
    }
}
