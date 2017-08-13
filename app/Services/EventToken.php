<?php
/**
 * Author: Xavier Au
 * Date: 11/8/2017
 * Time: 6:40 PM
 */

namespace App\Services;


use Anacreation\MultiAuth\Model\Admin;
use App\Event;
use Illuminate\Contracts\Auth\Authenticatable;

class EventToken
{
    public static function create(Authenticatable $admin, Event $event): string {
        $token = [
            $admin->id,
            $event->id,
            \Carbon\Carbon::now()->toDateTimeString()
        ];

        return encrypt($token);
    }

    public static function decrypted(string $token): array {
        return decrypt($token);
    }
}