<?php
/**
 * Author: Xavier Au
 * Date: 27/6/2017
 * Time: 7:01 PM
 */

namespace App\Services;


use App\User;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class SendEmail
{
    public function send(User $recipient, Mailable $mail, string $from = null, string $name = null, array $args = []) {
        Mail::to($recipient)->send($mail);
    }
}