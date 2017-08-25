<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy extends AbstractAdminPolicy
{
    use HandlesAuthorization;

    protected $shortName = 'Product';

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct() {
        //
    }
}
