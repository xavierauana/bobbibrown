<?php

namespace Tests\Unit;

use App\Events\UserSuccessfullyRegisterEvent;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class Event extends TestCase
{
    use DatabaseMigrations;

    public function test_authenticated_user_event_registration() {
        $user = factory(\App\User::class)->create();
        $event = factory(\App\Event::class)->create();
        $this->actingAs($user);

        $this->post(route('user.event.registration', $event->id))->assertStatus(200);
        $this->assertDatabaseHas('event_user', ['user_id' => $user->id, 'event_id' => $event->id]);
    }

    public function test_user_event_registration() {
        $event = factory(\App\Event::class)->create();
        $this->post(route('user.event.registration', $event->id))->assertStatus(302);
    }

    public function test_user_cannot_register_event_when_no_vacancy() {
        $event = factory(\App\Event::class)->create(['vacancies' => 1]);

        $user = factory(\App\User::class)->create();
        $this->actingAs($user);

        $this->post(route('user.event.registration', $event->id))->assertStatus(200);
        $this->assertDatabaseHas('event_user', ['user_id' => $user->id, 'event_id' => $event->id]);

        $user = factory(\App\User::class)->create();
        $this->actingAs($user);

        $this->post(route('user.event.registration', $event->id))->assertStatus(200);
        $this->assertDatabaseMissing('event_user', ['user_id' => $user->id, 'event_id' => $event->id]);

    }

    public function test_user_after_event_registration_trigger_event() {

        $this->expectsEvents(UserSuccessfullyRegisterEvent::class);

        $event = factory(\App\Event::class)->create(['vacancies' => 1]);
        $user = factory(\App\User::class)->create();
        $this->actingAs($user);
        $this->post(route('user.event.registration', $event->id));
    }
}
