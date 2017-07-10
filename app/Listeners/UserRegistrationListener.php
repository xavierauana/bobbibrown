<?php

namespace App\Listeners;

use App\Events\UserRegistration as Event;
use App\Mail\UserRegistration as Mail;
use App\Services\SendEmail;

class UserRegistrationListener
{
    /**
     * @var \App\Services\SendEmail
     */
    private $mailOperator;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SendEmail $mailOperator) {
        //
        $this->mailOperator = $mailOperator;
    }

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(Event $event) {
        $this->mailOperator->send($event->user, new Mail($event->user));
    }
}
