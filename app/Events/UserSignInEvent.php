<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class UserSignInEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var \App\User
     */
    public $user;
    /**
     * @var \App\Event
     */
    public $event;
    /**
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(User $user, \App\Event $event, Request $request) {
        //
        $this->user = $user;
        $this->event = $event;
        $this->request = $request;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn() {
        return new PrivateChannel('channel-name');
    }
}
