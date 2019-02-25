<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\MailCatcherTestCase;

class ResetPasswordTest extends MailCatcherTestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function get_reset_password_page() {
        $response = $this->get(url('password/reset'));

        $response->assertStatus(200)
                 ->assertSeeText("Send Password Reset Link");

    }

    /**
     * @test
     */
    public function reset_password_email_sent() {

        $user = factory(User::class)->create([
            'is_verified' => true,
            'is_approved' => true,
        ]);

        $data = [
            'email' => $user->email
        ];

        $this->post(url('/password/email'), $data);

        $email = $this->getLastEmail();

        $this->assertEmailWasSentTo($user->email, $email)
             ->assertEmailSubjectContains("Reset Password",
            $email);

    }
}
