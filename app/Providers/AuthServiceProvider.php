<?php

namespace App\Providers;

use Anacreation\Etvtest\Models\Test;
use App\Category;
use App\Collection;
use App\Event;
use App\Lesson;
use App\Line;
use App\Permission;
use App\Policies\CategoryPolicy;
use App\Policies\CollectionPolicy;
use App\Policies\EventPolicy;
use App\Policies\LessonPolicy;
use App\Policies\LinePolicy;
use App\Policies\PermissionPolicy;
use App\Policies\ProductPolicy;
use App\Policies\RolePolicy;
use App\Policies\SettingPolicy;
use App\Policies\TestPolicy;
use App\Policies\UserPolicy;
use App\Product;
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
        Line::class       => LinePolicy::class,
        Role::class       => RolePolicy::class,
        Test::class       => TestPolicy::class,
        User::class       => UserPolicy::class,
        Event::class      => EventPolicy::class,
        Lesson::class     => LessonPolicy::class,
        Setting::class    => SettingPolicy::class,
        Product::class    => ProductPolicy::class,
        Category::class   => CategoryPolicy::class,
        Collection::class => CollectionPolicy::class,
        Permission::class => PermissionPolicy::class,
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
