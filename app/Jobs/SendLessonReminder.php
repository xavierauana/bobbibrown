<?php

namespace App\Jobs;

use App\Lesson;
use App\Mail\LessonReminder as Mail;
use App\Services\SendEmail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendLessonReminder implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var \App\Lesson
     */
    private $lesson;
    /**
     * @var \App\User
     */
    private $user;

    /**
     * Create a new job instance.
     *
     * @param \App\Lesson $lesson
     * @param \App\User   $user
     */
    public function __construct(Lesson $lesson, User $user) {
        //
        $this->lesson = $lesson;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(SendEmail $mailOperator) {
        $mailOperator->send($this->user, new Mail($this->user, $this->lesson));
    }
}
