<?php

namespace Bhushanm\Laraman\Providers;

use Illuminate\Support\ServiceProvider;
use Bhushanm\Laraman\Models\Scope;

class LaramanServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // dd(config("database.default"));
        // Route::get('calculator', function(){
        //     echo 'Hello from the calculator package!';
        // });

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Register package routes
        Scope::generateRoutes();
    }
}
