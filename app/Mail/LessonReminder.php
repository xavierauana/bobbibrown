<?php

namespace App\Mail;

use App\Lesson;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LessonReminder extends Mailable
{
    use Queueable, SerializesModels;
    /**
     * @var \App\User
     */
    private $user;
    /**
     * @var string
     */
    private $name;
    /**
     * @var \App\Lesson
     */
    private $lesson;

    /**
     * Create a new message instance.
     *
     * @param \App\User   $user
     * @param \App\Lesson $lesson
     * @param string|null $from
     * @param string|null $name
     */
    public function __construct(User $user, Lesson $lesson, string $from = null, string $name = null) {
        //
        $this->user = $user;
        $this->from = $from;
        $this->name = $name;
        $this->lesson = $lesson;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from($this->from ?? config('mail.from.address'), $this->name ?? config('mail.from.name.'))
                    ->view('email.user.lesson_reminder')->with(['user' => $this->user, 'lesson' => $this->lesson]);
    }
}
