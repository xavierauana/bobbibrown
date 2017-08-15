<?php

namespace App\Listeners;

use App\Events\UserRegistration as Event;
use App\Events\UserSuccessfullyRegisterEvent;
use App\Jobs\SendEventRegistrationMail as Job;

class SendEventRegistrationEmail
{

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Event $event
     * @return void
     */
    public function handle(UserSuccessfullyRegisterEvent $event) {
        $job = new Job($event->user, $event->event);
        dispatch($job);
    }
}
