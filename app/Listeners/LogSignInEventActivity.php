<?php

namespace App\Listeners;

use App\Enums\EventActivityTypes;
use App\Events\UserRegistration as Event;
use App\Events\UserSignInEvent;

class LogSignInEventActivity
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
    public function handle(UserSignInEvent $event) {
        $event->user->eventActivities()->create([
            'ip'        => $event->request->ip(),
            'type'      => EventActivityTypes::SINGIN,
            'token'     => $event->request->get('token'),
            'event_id'  => $event->event->id,
            'latitude'  => $event->request->get('latitude'),
            'longitude' => $event->request->get('longitude'),
        ]);
    }
}
