<?php
/**
 * Author: Xavier Au
 * Date: 28/7/2017
 * Time: 2:46 PM
 */

namespace Anacreation\Scaffold;


use Illuminate\Support\ServiceProvider;

class ScaffoldServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Scaffold::class
            ]);
        }
    }


}