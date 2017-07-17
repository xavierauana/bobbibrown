<?php
/**
 * Author: Xavier Au
 * Date: 3/7/2017
 * Time: 11:56 AM
 */

namespace App\Policies;


use Anacreation\MultiAuth\Model\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;

class AbstractAdminPolicy
{
    use HandlesAuthorization;

    public function view(Admin $admin): bool {
        return $admin->hasPermission("index" . $this->shortName);
    }

    public function show(Admin $admin): bool {
        return $admin->hasPermission("show" . $this->shortName);
    }

    public function create(Admin $admin): bool {
        return $admin->hasPermission("create" . $this->shortName);
    }

    public function edit(Admin $admin): bool {
        return $admin->hasPermission("edit" . $this->shortName);
    }

    public function delete(Admin $admin): bool {
        return $admin->hasPermission("delete" . $this->shortName);
    }
}