<?php

namespace App\Jobs;

use App\Event;
use App\Mail\PublishEventMail;
use App\Services\SendEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PublishEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var \App\Event
     */
    private $event;
    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     * @param \App\Event $event
     * @param \App\User  $user
     */
    public function __construct(Event $event, User $user) {
        $this->event = $event;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendEmail $mailOperator) {
        $mailOperator->send($this->user, new PublishEventMail($this->user, $this->event));
    }
}
