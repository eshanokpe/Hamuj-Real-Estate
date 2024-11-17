<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Faqs;
use App\Models\Post;
use App\Models\About;
use App\Models\Property;
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
        View::share('posts', Post::latest()->paginate(20)); 
        View::share('about', About::first()); 
        View::share('properties', Property::all()); 
        View::share('recentProperties', Property::inRandomOrder()->take(6)->get());
        View::share('recentBlog', Post::inRandomOrder()->take(6)->get());
        View::share('visionMission', VisionMission::first());  
        View::share('contactDetials', ContactDetials::first()); 
    }
}
