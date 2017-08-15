<?php

namespace App\Mail;

use App\Event;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class EventCancelRegistrationConfirm extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var \App\User
     */
    private $user;
    /**
     * @var \App\Event
     */
    private $event;

    /**
     * Create a new message instance.
     *
     * @param \App\User  $user
     * @param \App\Event $event
     */
    public function __construct(User $user, Event $event, string $from = null, string $name = null) {
        //
        $this->user = $user;
        $this->event = $event;
        $this->from = $from;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from($this->from??config('mail.from.address'), $this->name??config('mail.from.name.'))
                    ->subject("Cancel Event Registration, {$this->event->title}")->view('email.event.cancel')
                    ->with(['user' => $this->user, 'event' => $this->event]);
    }
}
