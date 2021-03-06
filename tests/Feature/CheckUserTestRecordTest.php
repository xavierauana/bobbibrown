<?php

namespace Tests\Feature;

use Anacreation\Etvtest\Models\Attempt;
use Anacreation\Etvtest\Models\Test;
use Anacreation\MultiAuth\Model\Admin;
use App\Lesson;
use App\Permission;
use App\Role;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CheckUserTestRecordTest extends TestCase
{
    use DatabaseMigrations;

    protected $admin;
    protected $user;
    protected $lesson;

    protected function setUp() {
        parent::setUp(); // TODO: Change the autogenerated stub

        $this->admin = $this->createAdmin();

        $this->actingAs($this->admin, 'admin');

        list($this->user, $this->lesson) = $this->createUserAndLessonWithTest();
    }

    /**
     * @test
     */
    public function show_user_test_records() {

        $response = $this->get("admin/lessons/{$this->lesson->id}/users/{$this->user->id}/records");

        $response->assertStatus(200);
        $response->assertViewIs("tests.user_records");
        $response->assertViewHas(['user', 'test', 'attempts']);
    }

    /**
     * @test
     */
    public function has_3_attempts() {

        for ($i = 0; $i < 3; $i++) {
            factory(Attempt::class)->create([
                'user_id' => $this->user->id,
                'test_id' => $this->lesson->tests->first()->id
            ]);
        }

        $response = $this->get("admin/lessons/{$this->lesson->id}/users/{$this->user->id}/records");

        $content = $response->getOriginalContent();

        $attempts = $content['attempts'];

        $this->assertEquals(3, $attempts->count());
    }


    private function createLessonWithTest(Role $role): Lesson {

        $test = factory(Test::class)->create();

        $lesson = factory(Lesson::class)->create([
            'permission_id' => $role->permissions->first()->id
        ]);

        $lesson->tests()->save($test);

        return $lesson;
    }

    private function createRoleWithPermission($numberOfPermissions = 1): Role {
        $permissions = factory(Permission::class,
            $numberOfPermissions)->create();

        $role = factory(Role::class)->create();

        $permissions->each(function ($permission) use ($role) {
            $role->permissions()->save($permission);
        });


        return $role;
    }

    private function createUserAndLessonWithTest(): array {
        $role = $this->createRoleWithPermission();

        $user = factory(User::class)->create();

        $user->roles()->save($role);

        $lesson = $this->createLessonWithTest($role);

        return [$user, $lesson];
    }

    private function createAdmin(): Admin {

        $admin = factory(Admin::class)->create();

        return $admin;
    }
}
