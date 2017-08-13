<?php

namespace App\Listeners;

use App\Enums\EventActivityTypes;
use App\Events\UserRegistration as Event;
use App\Events\UserSuccessfullyRegisterEvent;

class LogEventRegistrationActivity
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
        $event->user->logEventActivity(EventActivityTypes::REGISTRATION, $event->event, $event->request);
    }
}
