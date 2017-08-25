<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy extends AbstractAdminPolicy
{
    use HandlesAuthorization;

    protected $shortName = "Category";

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }
}
