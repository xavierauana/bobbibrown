<?php

namespace App\Policies;

use App\Menu;

class MenuPolicy extends AbstractAdminPolicy
{

    protected $shortName;

    /**
     * EventPolicy constructor.
     */
    public function __construct() {
        $reflect = new \ReflectionClass(Menu::class);
        $this->shortName = ucwords($reflect->getShortName());
    }
}
