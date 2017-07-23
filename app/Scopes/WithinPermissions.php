<?php
/**
 * Author: Xavier Au
 * Date: 23/7/2017
 * Time: 6:29 PM
 */

namespace App\Scopes;


use App\User;

trait WithinPermissions
{
    public function scopeAvailable($query, User $user) {
        return $query->whereIn('permission_id', $user->permissions->pluck('id')->toArray());
    }
}