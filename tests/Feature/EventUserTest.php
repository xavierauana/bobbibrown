<?php

namespace Tests\Feature;

use App\Collection;
use App\Event;
use App\Events\UserSuccessfullyRegisterEvent;
use App\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Mockery\Mock;
use Tests\TestCase;

class EventUserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_authenticated_user_with_right_permission_event_registration(
    ) {
        list($role, $permission) = $this->createRoleAndPermission();

        $user = factory(User::class)->create();
        $user->roles()->save($role);
        $event = factory(Event::class)->create([
            'permission_id' => $permission->id
        ]);
        $this->actingAs($user);

        $this->expectsEvents(UserSuccessfullyRegisterEvent::class);

        $this->post(route('user.event.registration', $event->id));

        $this->assertDatabaseHas('event_user',
            ['user_id' => $user->id, 'event_id' => $event->id]);
    }

    public function test_authenticated_user_without_right_permission_event_registration(
    ) {
        list($role, $permission) = $this->createRoleAndPermission();


        $user = factory(User::class)->create();
        $event = factory(Event::class)->create([
            'permission_id' => $permission->id
        ]);
        $this->actingAs($user);

        $this->post(route('user.event.registration', $event->id))
             ->assertStatus(501);
    }

    public function test_user_event_registration() {
        $event = factory(Event::class)->create();
        $this->post(route('user.event.registration', $event->id))
             ->assertStatus(302);
    }

    // User has correct permission but not vacancy
    public function test_user_can_register() {
        list($role, $permission) = $this->createRoleAndPermission();

        $event = factory(Event::class)->create([
            'vacancies'     => 1,
            'permission_id' => $permission->id
        ]);

        $user = factory(User::class)->create();
        $user->roles()->save($role);
        $this->actingAs($user);

        $this->expectsEvents(UserSuccessfullyRegisterEvent::class);
        $response = $this->post(route('user.event.registration',
            $event->id));
        $response->assertJsonStructure(['status', 'user']);
    }

    public function test_user_cannot_register() {
        list($role, $permission) = $this->createRoleAndPermission();
        list($role1, $permission1) = $this->createRoleAndPermission();

        $event = factory(Event::class)->create([
            'vacancies'     => 0,
            'permission_id' => $permission1->id
        ]);

        $user = factory(User::class)->create();
        $user->roles()->save($role);
        $this->actingAs($user);
        $response = $this->post(route('user.event.registration',
            $event->id));

        $response->assertStatus(501);
        $this->assertEquals("Cannot register!",
            $response->baseResponse->getContent());
    }

    public function test_user_after_event_registration_trigger_event() {
        list($role, $permission) = $this->createRoleAndPermission();

        $this->expectsEvents(UserSuccessfullyRegisterEvent::class);

        $event = factory(Event::class)->create([
            'vacancies'     => 1,
            'permission_id' => $permission->id
        ]);
        $user = factory(User::class)->create();
        $user->roles()->save($role);
        $this->actingAs($user);
        $this->post(route('user.event.registration', $event->id));
    }

    public function test_get_new_events_for_index_page() {
        list($role, $permission) = $this->createRoleAndPermission();
        $user = factory(User::class)->create();
        $user->roles()->save($role);
        $events = factory(Event::class, 3)->create([
            'permission_id' => $permission->id,
        ]);

        $user->register($events->first());

        $availableEvents = Event::matchUserPermissions($user)->latest()
                                ->where("start_datetime", ">", Carbon::now())
                                ->notRegistered($user)->get();

        $this->assertEquals(2, $availableEvents->count());
    }

    /**
     * @return array
     */
    protected function createRoleAndPermission(): array {
        $role = factory(\App\Role::class)->create();
        $permission = factory(\App\Permission::class)->create();
        $role->permissions()->save($permission);

        return array($role, $permission);
    }


}
