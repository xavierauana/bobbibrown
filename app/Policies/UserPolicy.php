<?php

namespace App\Policies;

use App\User;

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
