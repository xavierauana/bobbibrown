<?php

namespace App\Policies;


use App\Permission;

class PermissionPolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $reflect = new \ReflectionClass(Permission::class);
        $this->shortName = 'User' . ucwords($reflect->getShortName());
    }
}
