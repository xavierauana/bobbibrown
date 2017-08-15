<?php

namespace App\Jobs;

use App\Event;
use App\Mail\EventRegistrationConfirm as Mail;
use App\Services\SendEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendEventRegistrationMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var \App\User
     */
    private $user;
    /**
     * @var \App\Event
     */
    private $event;

    /**
     * Create a new job instance.
     *
     * @param \App\User  $user
     * @param \App\Event $event
     */
    public function __construct(User $user, Event $event) {
        //
        $this->user = $user;
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendEmail $mailOperator) {
        $mailOperator->send($this->user, new Mail($this->user, $this->event));
    }
}
