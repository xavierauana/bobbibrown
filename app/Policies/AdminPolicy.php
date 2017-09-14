<?php
/**
 * Author: Xavier Au
 * Date: 13/9/2017
 * Time: 2:26 PM
 */

namespace App\Policies;


use Anacreation\MultiAuth\Model\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AdminPolicy
{
    use HandlesAuthorization;

    protected $className = "Admin";

    public function view(Admin $admin): bool {
        return $admin->hasPermission("index" . $this->className);
    }

    public function show(Admin $admin): bool {
        return $admin->hasPermission("show" . $this->className);
    }

    public function create(Admin $admin): bool {
        return $admin->hasPermission("create" . $this->className);
    }

    public function edit(Admin $admin): bool {
        return $admin->hasPermission("edit" . $this->className);
    }

    public function delete(Admin $admin): bool {
        return $admin->hasPermission("delete" . $this->className);
    }
}