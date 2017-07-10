<?php

namespace App\Policies;

use App\Event;

class EventPolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $reflect = new \ReflectionClass(Event::class);
        $this->shortName = ucwords($reflect->getShortName());
    }
}
