<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
    // public function boot(UrlGenerator $url)
    // {
    //     //
    //     if(env('ENFORCE_SSL', false)) {
    //         $url->forceScheme('https');
    //     }
    // }
}
