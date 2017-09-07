<?php

namespace Tests\Unit;

use App\Lesson;
use App\LessonSchedule;
use App\Services\LessonDeadlineCalculator;
use App\User;
use Carbon\Carbon;
use Tests\TestCase;

// TODO: haven't finisehed
class DeadlineCalculatorTest extends TestCase
{


    public function test_schedule_compare_user_with_new_user() {

        $lesson = factory(Lesson::class)->create();
        factory(LessonSchedule::class)->create([
            'compare'   => 'user',
            'lesson_id' => $lesson->id,
        ]);

        $user = factory(User::class)->create();

        $calculator = new LessonDeadlineCalculator($lesson);

        $this->assertEquals(10, $calculator->dueInDate($user));
    }

    public function test_schedule_compare_user_with_old_user() {

        $lesson = factory(Lesson::class)->create();
        factory(LessonSchedule::class)->create([
            'compare'   => 'user',
            'lesson_id' => $lesson->id,
        ]);

        $user = factory(User::class)->create([
            "created_at" => Carbon::now()->addDays(-2)
        ]);

        $calculator = new LessonDeadlineCalculator($lesson);

        $this->assertEquals(10, $calculator->dueInDate($user));
    }

    public function test_schedule_compare_lesson_with_old_user() {

        $lesson = factory(Lesson::class)->create();
        factory(LessonSchedule::class)->create([
            'compare'   => 'lesson',
            'lesson_id' => $lesson->id,
        ]);

        $user = factory(User::class)->create([
            "created_at" => Carbon::now()->addDays(-2)
        ]);

        $calculator = new LessonDeadlineCalculator($lesson);

        $this->assertEquals(10, $calculator->dueInDate($user));
    }

    public function test_schedule_compare_lesson_when_lesson_created_before() {

        $lesson = factory(Lesson::class)->create([
            'created_at' => Carbon::now()->addDays(-2)
        ]);
        factory(LessonSchedule::class)->create([
            'compare'   => 'lesson',
            'lesson_id' => $lesson->id,
        ]);

        $user = factory(User::class)->create();

        $calculator = new LessonDeadlineCalculator($lesson);

        $this->assertEquals(10, $calculator->dueInDate($user));
    }

    public function test_schedule_compare_lesson_when_lesson_and_user_created_before(
    ) {

        $lesson = factory(Lesson::class)->create([
            'created_at' => Carbon::now()->addDays(-2)
        ]);
        factory(LessonSchedule::class)->create([
            'compare'   => 'lesson',
            'lesson_id' => $lesson->id,
        ]);

        $user = factory(User::class)->create([
            'created_at' => Carbon::now()->addDays(-2)
        ]);

        $calculator = new LessonDeadlineCalculator($lesson);

        $this->assertEquals(8, $calculator->dueInDate($user));
    }

    public function test_schedule_compare_lesson_when_overdue() {

        $lesson = factory(Lesson::class)->create([
            'created_at' => Carbon::now()->addDays(-12)
        ]);
        factory(LessonSchedule::class)->create([
            'compare'   => 'lesson',
            'lesson_id' => $lesson->id,
        ]);

        $user = factory(User::class)->create([
            'created_at' => Carbon::now()->addDays(-12)
        ]);

        $calculator = new LessonDeadlineCalculator($lesson);

        $this->assertEquals(-1, $calculator->dueInDate($user));
    }
}
