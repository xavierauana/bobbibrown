<?php

namespace Tests\Unit;

use App\Collection;
use App\Event;
use App\Lesson;
use App\Permission;
use App\Role;
use App\Test;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

// TODO:: going to finished user model test
class UserModelTest extends TestCase
{
    use DatabaseMigrations;

    public function test_pass_collection() {

        $collection = $this->createACollectionWithNumberOfLessonsAndTest(3);

    }

    public function test_user_has_event_permission() {
        $permission = factory(Permission::class)->create();

        $role1 = factory(Role::class)->create();
        $role1->permissions()->save($permission);

        $role2 = factory(Role::class)->create();

        $user1 = factory(User::class)->create();
        $user1->roles()->save($role1);
        $user2 = factory(User::class)->create();
        $user2->roles()->save($role2);

        $event = factory(Event::class)->create([
            'permission_id' => $permission->id
        ]);

        $this->assertTrue($user1->hasEventPermission($event));
        $this->assertFalse($user2->hasEventPermission($event));

    }

    protected
    function createACollectionWithNumberOfLessonsAndTest(
        $numberOfLessons
    ): Collection {
        $permission = factory(Permission::class)->create();

        $collection = factory(Collection::class)->create([
            'permission_id' => $permission->id
        ]);

        $collection->tests()->save(factory(Test::class)->create());

        factory(Lesson::class, $numberOfLessons)->create([
            'permission_id' => $permission->id
        ])->each(function (Lesson $lesson) use ($collection) {
            $lesson->collections()->save($collection);
            $lesson->tests()->save(factory(Test::class)->create());
        });

        return $collection;
    }
}
