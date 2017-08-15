<?php

namespace App\Providers;

use App\Events\UserCancelEventRegistration;
use App\Events\UserRegistration;
use App\Events\UserSignInEvent;
use App\Events\UserSuccessfullyRegisterEvent;
use App\Listeners\LogCancelEventRegistrationActivity;
use App\Listeners\LogEventRegistrationActivity;
use App\Listeners\LogSignInEventActivity;
use App\Listeners\SendCancelEventRegistrationEmail;
use App\Listeners\SendEventRegistrationEmail;
use App\Listeners\UserRegistrationListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event'                   => [
            'App\Listeners\EventListener',
        ],
        UserRegistration::class              => [
            UserRegistrationListener::class,
        ],
        UserSuccessfullyRegisterEvent::class => [
            LogEventRegistrationActivity::class,
            SendEventRegistrationEmail::class,
        ],
        UserCancelEventRegistration::class   => [
            LogCancelEventRegistrationActivity::class,
            SendCancelEventRegistrationEmail::class
        ],
        UserSignInEvent::class               => [
            LogSignInEventActivity::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot() {
        parent::boot();

        //
    }
}
