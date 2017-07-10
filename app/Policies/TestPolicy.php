<?php

namespace App\Policies;


use Anacreation\Etvtest\Models\Test;

class TestPolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $reflect = new \ReflectionClass(Test::class);
        $this->shortName = ucwords($reflect->getShortName());
    }
}
