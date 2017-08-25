<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class LinePolicy extends AbstractAdminPolicy
{
    use HandlesAuthorization;

    protected $shortName="Line";

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }
}
