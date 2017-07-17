<?php

namespace App\Policies;

class UserPolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $this->shortName = 'User';
    }
}
