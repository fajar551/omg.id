<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class StreamCreator implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $payloads = [];

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(array $payloads)
    {
        $this->payloads = $payloads;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel("stream.creator");
    }

    public function broadcastAs()
    {
        return 'stream.creator';
    }

    public function broadcastWith(){
        return [
            'payloads' => $this->payloads
        ];
    }

}
