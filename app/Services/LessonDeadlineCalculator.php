<?php
/**
 * Author: Xavier Au
 * Date: 13/8/2017
 * Time: 4:47 PM
 */

namespace App\Services;


use App\Lesson;
use App\User;
use Carbon\Carbon;

class LessonDeadlineCalculator
{
    /**
     * @var \App\Lesson
     */
    private $lesson;

    /**
     * LessonDeadlineCalculator constructor.
     * @param \App\Lesson $lesson
     */
    public function __construct(Lesson $lesson) {
        $this->lesson = $lesson;
    }

    #region Public API

    public function isOverDue(User $user, Lesson $lesson = null): bool {

        $lesson = $lesson ?: $this->lesson;

        $date = $this->getCurrentOrPassedAttemptDate($user, $lesson);

        $deadline = $this->getDeadline($user, $lesson);

        return $date->greaterThan($deadline);
    }

    public function dueInDate(User $user, Lesson $lesson = null): int {

        $lesson = $lesson ?: $this->lesson;

        if ($this->isOverDue($user, $lesson)) {
            return -1;
        }

        $date = $this->getCurrentOrPassedAttemptDate($user, $lesson);

        $deadline = $this->getDeadline($user, $lesson);

        return $deadline->diffInDays($date);
    }

    #endregion

    #region Private

    private function getDeadline(User $user, Lesson $lesson): Carbon {

        $theDate = null;

        if ($lesson->schedule->compare == 'user') {

            $theDate = $user->created_at > $lesson->created_at ? $user->created_at : $lesson->created_at;
        } else {
            $theDate = $lesson->created_at > $user->created_at ? $lesson->created_at : $user->created_at;
        }


        return $theDate->addDays($lesson->schedule->days);
    }

    /**
     * @param \App\User   $user
     * @param \App\Lesson $lesson
     */
    private function getLastPassedAttemptDate(User $user, Lesson $lesson
    ):?Carbon {
        if ($test = $lesson->test and $lastPassedAttempt = $user->latestPassedAttempts($test)
                                                                ->first()) {
            return $lastPassedAttempt->created_at;
        }

        return null;
    }

    private function getCurrentOrPassedAttemptDate(User $user, Lesson $lesson
    ): Carbon {
        if ($attemptDate = $this->getLastPassedAttemptDate($user, $lesson)) {
            return $attemptDate;
        }

        return Carbon::now();
    }

    #endregion
}