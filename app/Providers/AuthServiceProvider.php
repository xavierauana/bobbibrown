<?php

namespace App\Providers;

use Anacreation\Etvtest\Models\Test;
use App\Collection;
use App\Event;
use App\Lesson;
use App\Menu;
use App\Permission;
use App\Policies\CollectionPolicy;
use App\Policies\EventPolicy;
use App\Policies\LessonPolicy;
use App\Policies\MenuPolicy;
use App\Policies\PermissionPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\TestPolicy;
use App\Policies\UserPolicy;
use App\Role;
use App\Setting;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Event::class      => EventPolicy::class,
        Collection::class => CollectionPolicy::class,
        Lesson::class     => LessonPolicy::class,
        Permission::class => PermissionPolicy::class,
        Role::class       => RolePolicy::class,
        Test::class       => TestPolicy::class,
        User::class       => UserPolicy::class,
        Setting::class    => SettingPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot() {
        $this->registerPolicies();

        //
    }
}
