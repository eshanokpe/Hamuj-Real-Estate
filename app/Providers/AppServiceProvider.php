<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\MenuItem;
use Illuminate\Support\Facades\View;

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
        View::share('menuItems', MenuItem::with('dropdownItems')->get()); 
    }
}
