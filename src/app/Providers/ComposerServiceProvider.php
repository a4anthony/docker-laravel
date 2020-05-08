<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //For main store
        View::composer(
            '*',
            'App\Http\View\Composers\ProductsComposer'
        );
        //For admin panel
        View::composer(
            '*',
            'App\Http\Composers\DashboardComposer'
        );
    }
}
