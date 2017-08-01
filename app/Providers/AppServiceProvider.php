<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        Schema::defaultStringLength(191);

        if (app()->environment() != "production") {
            app()->register(\Barryvdh\Debugbar\ServiceProvider::class);
            app()->register(\Anacreation\Scaffold\ScaffoldServiceProvider::class);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        //
    }
}
