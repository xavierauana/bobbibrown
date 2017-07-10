<?php

namespace App\Policies;

use App\Collection;

class CollectionPolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $reflect = new \ReflectionClass(Collection::class);
        $this->shortName = ucwords($reflect->getShortName());
    }
}
