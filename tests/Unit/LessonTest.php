<?php

namespace Tests\Unit;

use App\Collection;
use App\Lesson;
use App\Permission;
use App\Services\LessonDeadlineCalculator;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class LessonTest extends TestCase
{
    use DatabaseMigrations;

    public function test_permission() {
        $permission = factory(Permission::class)->create();
        $lesson = factory(Lesson::class)->create([
            'permission_id' => $permission->id
        ]);
        $this->assertEquals($permission->id, $lesson->permission->id);
    }

    public function test_is_overdue() {
        $lesson = factory(Lesson::class)->create();

        $calculatorMock = \Mockery::mock(LessonDeadlineCalculator::class);
        $userMock = \Mockery::mock(User::class);
        $this->app->instance(LessonDeadlineCalculator::class, $calculatorMock);
        $this->app->instance(User::class, $userMock);
        $calculatorMock->shouldReceive('setLesson')->once();
        $calculatorMock->shouldReceive('isOverDue')->once()->andReturn(true);

        $this->assertTrue($lesson->isOverDue(app(User::class)));
    }

    public function test_due_in_days() {
        $lesson = factory(Lesson::class)->create();

        $calculatorMock = \Mockery::mock(LessonDeadlineCalculator::class);
        $userMock = \Mockery::mock(User::class);
        $this->app->instance(LessonDeadlineCalculator::class, $calculatorMock);
        $this->app->instance(User::class, $userMock);
        $calculatorMock->shouldReceive('setLesson')->once();
        $calculatorMock->shouldReceive('dueInDate')->once()->andReturn(3);

        $this->assertEquals(3, $lesson->dueInDays(app(User::class)));
    }

    public function test_scope_ordered() {
        $collection = factory(Collection::class)->create();
        $lessons = factory(Lesson::class, 5)->create()->each(function (
            $lesson,
            $index
        ) use ($collection) {
            $collection->lessons()->save($lesson, ['order' => 5 - $index]);
        });
        $this->assertTrue(array_reverse($lessons->pluck('id')
                                                ->toArray()) == $collection->lessons()
                                                                           ->Ordered()
                                                                           ->pluck('id')
                                                                           ->toArray());
    }


}
