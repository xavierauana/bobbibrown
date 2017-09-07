<?php

namespace Tests\Unit;

use App\Event;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

class EventModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_remove_user() {
        $user = factory(User::class)->create();

        $event = factory(Event::class)->create();

        $event->users()->save($user);

        $this->assertDatabaseHas('event_user', [
            'user_id'  => $user->id,
            'event_id' => $event->id,
        ]);

        $event->removeUser($user);

        $this->assertDatabaseMissing('event_user', [
            'user_id'  => $user->id,
            'event_id' => $event->id,
        ]);

    }

    public function test_match_user_permission() {

        $permission1 = factory(Permission::class)->create();
        $permission2 = factory(Permission::class)->create();
        $role1 = factory(Role::class)->create();
        $role2 = factory(Role::class)->create();
        $role1->permissions()->save($permission1);
        $role2->permissions()->save($permission2);

        $user1 = factory(User::class)->create();
        $user2 = factory(User::class)->create();
        $user1->roles()->save($role1);
        $user2->roles()->save($role2);


        $count1 = 2;
        $count2 = 3;

        for ($i = 0; $i < $count1; $i++) {
            $this->createEventWitPermission($permission1);
        }

        for ($i = 0; $i < $count2; $i++) {
            $this->createEventWitPermission($permission2);
        }


        $this->assertEquals($count1,
            Event::matchUserPermissions($user1)->count());
        $this->assertEquals($count2,
            Event::matchUserPermissions($user2)->count());

    }

    public function test_get_not_register_events() {
        $user = factory(User::class)->create();
        $count = 5;
        $registered = 2;
        $events = factory(Event::class, $count)->create();

        for ($i = 0; $i < $registered; $i++) {
            $events[$i]->users()->save($user);
        }

        $this->assertEquals(Event::count() - $registered,
            Event::notRegistered($user)->count());
    }

    public function test_get_active_events() {
        $user1 = factory(User::class)->create();
        $permission = factory(Permission::class)->create();
        $events = factory(Event::class, 10)->create([
            "permission_id" => $permission->id
        ]);

        $role = factory(Role::class)->create();
        $role->permissions()->save($permission);
        $user2 = factory(User::class)->create();
        $user2->roles()->save($role);

        $this->assertEquals(0, Event::getActiveEventsForUser($user1)->count());
        $this->assertEquals(10, Event::getActiveEventsForUser($user2)->count());

    }

    private function createEventWitPermission(Permission $permission): Event {
        return factory(Event::class)->create([
            'permission_id' => $permission->id
        ]);
    }
}
