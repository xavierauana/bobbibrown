<?php

namespace App\Events;

use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;

class UserSuccessfullyRegisterEvent
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
     * @param \App\User                $user
     * @param \App\Event               $event
     * @param \Illuminate\Http\Request $request
     */
    public function __construct(User $user, \App\Event $event, Request $request) {
        //
        $this->user = $user;
        $this->event = $event;
        $this->request = $request;
    }
}
