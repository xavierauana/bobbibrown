<?php

namespace App\Listeners;

use App\Enums\EventActivityTypes;
use App\Events\UserCancelEventRegistration;
use App\Events\UserRegistration as Event;
use App\Events\UserSuccessfullyRegisterEvent;

class LogCancelEventRegistrationActivity
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
    public function handle(UserCancelEventRegistration $event) {
        $event->user->logEventActivity(EventActivityTypes::REGISTRATION, $event->event, $event->request);
    }
}
