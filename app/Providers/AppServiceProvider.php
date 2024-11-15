<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Faqs;
use App\Models\About;
use App\Models\MenuItem;
use App\Models\VisionMission;
use App\Models\ContactDetials;

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
        View::share('faqs', Faqs::all()); 
        View::share('about', About::first()); 
        View::share('visionMission', VisionMission::first()); 
        View::share('contactDetials', ContactDetials::first()); 
    }
}
