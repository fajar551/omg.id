<?php

namespace App\Notifications;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTipNotification extends Notification implements ShouldQueue
{
    use Queueable;

    // public $afterCommit = true;

    private $params;

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
        if (!$this->params["test"]) {
            $via[] = 'database';
        }
        $via[] = 'broadcast';
    
        return $via;
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
            "new_tip" => $this->params["new_tip"],
            "new_tip_to" => $this->params["new_tip_to"],
            "supporter_notify" => $this->params["broadcast_to_supporter"] ? 1 : 0,

            // "new_tip_to" => [
            //     "id" => $notifiable->id,
            //     "name" => $notifiable->name,
            //     "username" => $notifiable->username,
            //     "page_url" => $notifiable->page->page_url,
            //     "email" => $notifiable->email,
            //     "support_type" => $this->params["support_type"] ?? 1,
            // ],
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
            'payloads' => [
                "test" => $this->params["test"],
                "real_data" => $this->params["real_data"],
                "streamKey" => $this->params["streamKey"],
                "new_tip" => $this->params["new_tip"],
                "media_share" => $this->params["media_share"],
                "notify_type" => $this->params["channels"],
            ],
            'notify_id' => !$this->params["test"] ? $notifiable->notifications()->latest()->first()->id : null,
        ];
    }

    /**
     * Get the type of the notification being broadcast.
     *
     * @return string
     */
    public function broadcastType()
    {
        return 'notify.new_tip';
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $broadCastTo = $this->params["broadcast_to_supporter"] ? ($this->params["supporter_id"] ?? '') : $this->params["userid"];
        $channels[] = new PrivateChannel("broadcast.user.{$broadCastTo}");

        if (isset($this->params["support_type"]) && $this->params["support_type"] == 2) {   // 1 = Support Only; 2 = Support Content/Support for subscribe content

        } else {
            // Broadcast notification widget overlay for Support Only not Support Content
            if (!$this->params["broadcast_to_supporter"]) {
                $channels[] = new Channel("stream.new_tip.{$this->params["streamKey"]}");
            }
        }

        return $channels;
    }
}
