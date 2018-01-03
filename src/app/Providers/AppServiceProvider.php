<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Compatibility with microservice setup.
        URL::forceRootUrl("http://appserver/static/");
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
