<?php

namespace App\Policies;


use App\Lesson;

class LessonPolicy extends AbstractAdminPolicy
{

    protected $shortName;

/**
     * EventPolicy constructor.
     */
    public function __construct() {
        $reflect = new \ReflectionClass(Lesson::class);
        $this->shortName = ucwords($reflect->getShortName());
    }
}
