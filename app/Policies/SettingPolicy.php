<?php

namespace App\Policies;

class SettingPolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $this->shortName = 'Setting';
    }
}
