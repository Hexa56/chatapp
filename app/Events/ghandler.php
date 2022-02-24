<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ghandler implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $sender;
    public $message;
    public $id;
    public $group_name;
    public $time;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($sender, $message, $id, $group_name, $time)
    {
        $this->sender = $sender;
        $this->message = $message;
        $this->id = $id;
        $this->group_name = $group_name;
        $this->time = $time;

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new channel('chat');
    }

    public function broadcastAs()
    {
        return "msg";
    }
}
