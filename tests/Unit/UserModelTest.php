<?php

namespace Tests\Unit;

use App\Collection;
use App\Lesson;
use App\Permission;
use App\Test;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
// TODO:: going to finished user model test
class UserModelTest extends TestCase
{
    use DatabaseTransactions;

    public function test_pass_collection() {

        $collection = $this->createACollectionWithNumberOfLessonsAndTest(3);

    }

    protected function createACollectionWithNumberOfLessonsAndTest(
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
