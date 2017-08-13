<?php

namespace App\Listeners;

use App\Events\UserRegistration as Event;
use App\Jobs\EmailJob;

class UserRegistrationListener
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
    public function handle(Event $event) {

        $job = new EmailJob($event->user);

        dispatch($job);

    }
}
