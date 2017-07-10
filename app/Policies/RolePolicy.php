<?php

namespace App\Policies;


use App\Role;

class RolePolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $reflect = new \ReflectionClass(Role::class);
        $this->shortName = 'User' . ucwords($reflect->getShortName());
    }
}
