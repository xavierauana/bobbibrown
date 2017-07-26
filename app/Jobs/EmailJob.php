<?php

namespace App\Jobs;

use App\Mail\UserRegistration as Mail;
use App\Services\SendEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param \App\User $user
     */
    public function __construct(User $user) {

        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @param \App\Services\SendEmail $mailOperator
     * @return void
     */
    public function handle(SendEmail $mailOperator) {
        $mailOperator->send($this->user, new Mail($this->user));
    }
}
