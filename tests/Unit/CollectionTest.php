<?php

namespace Tests\Unit;

use Anacreation\Etvtest\Models\Test;
use App\Collection;
use App\Lesson;
use App\Permission;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class CollectionTest extends TestCase
{
    use DatabaseMigrations;

    public function test_permission() {
        $permission = factory(Permission::class)->create();
        $collection = factory(Collection::class)->create([
            'permission_id' => $permission->id
        ]);
        $this->assertEquals($permission->id, $collection->permission->id);
    }

    public function test_has_test_with_test() {

        $collection = factory(Collection::class)->create();
        $collection->tests()->save(factory(Test::class)->create());

        $this->assertEquals(true, $collection->hasTest());
    }

    public function test_has_test_with_no_test() {

        $collection = factory(Collection::class)->create();

        $this->assertEquals(false, $collection->hasTest());
    }

    public function test_set_description_attribute() {
        factory(Collection::class)->create([
            'description' => " has space at the begin and end "
        ]);

        $this->assertEquals("has space at the begin and end",
            Collection::first()->description);
    }

    public function test_is_pass_all_lesson_tests_passed() {

        $userMock = \Mockery::mock(User::class);

        $this->app->instance(User::class, $userMock);

        $userMock->shouldReceive('passTest')->times(3)->andReturn(true);

        $collection = factory(Collection::class)->create();

        factory(Lesson::class, 3)->create()->each(function ($lesson) use (
            $collection
        ) {
            $lesson->tests()->save(factory(Test::class)->create());
            $collection->lessons()->save($lesson);
        });

        $this->assertTrue($collection->isPassAllLessonsTest(app(User::class)));

    }

    public function test_collection_hasTest_no_collection_and_lesson_test() {
        $collection = factory(Collection::class)->create();
        $lesson = factory(Lesson::class)->create();
        $collection->lessons()->save($lesson);
        $this->assertFalse($collection->hasTest());
    }

    public function test_collection_hasTest_with_lesson_test_only() {
        $collection = factory(Collection::class)->create();
        $lesson = factory(Lesson::class)->create();
        $lesson->tests()->save(factory(Test::class)->create());
        $collection->lessons()->save($lesson);
        $this->assertTrue($collection->hasTest());
    }

    public function test_collection_hasTest_with_collection_test_only() {
        $collection = factory(Collection::class)->create();
        $lesson = factory(Lesson::class)->create();
        $collection->lessons()->save($lesson);
        $collection->tests()->save(factory(Test::class)->create());
        $this->assertTrue($collection->hasTest());
    }

    public function test_collection_hasTest_with_both_collection_and_lesson_test(
    ) {
        $lesson = factory(Lesson::class)->create();
        $collection = factory(Collection::class)->create();
        $lesson->tests()->save(factory(Test::class)->create());
        $collection->tests()->save(factory(Test::class)->create());
        $collection->lessons()->save($lesson);
        $this->assertTrue($collection->hasTest());
    }

}
