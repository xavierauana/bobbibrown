<?php

namespace App\Mail;

use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class UserRegistration extends Mailable
{
    use Queueable, SerializesModels;
    public $user;
    public $from;
    public $name;


    /**
     * Create a new message instance.
     *
     * @param \App\User   $user
     * @param string|null $from
     * @param string|null $name
     */
    public function __construct(User $user, string $from = null, string $name = null) {
        //
        $this->user = $user;
        $this->from = $from;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->from($this->from??config('mail.from.address'), $this->name??config('mail.from.name.'))
                    ->view('email.user.registration')->with(['user' => $this->user]);
    }
}
