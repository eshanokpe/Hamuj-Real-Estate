<?php

namespace App\Providers;
use App\Services\WalletService;
use function App\Helpers\getWalletBalance;
use Illuminate\Support\ServiceProvider;

use Auth;
use App\Models\User;
use App\Models\Faqs;
use App\Models\Post;
use App\Models\About;
use App\Models\Terms;
use App\Models\Privacy;
use App\Models\Property;
use App\Models\Sociallink;
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
        // View::share('properties', Property::inRandomOrder()->take(6)->get()); 
        View::share('recentProperties', Property::inRandomOrder()->take(6)->get());
        View::share('recentBlog', Post::inRandomOrder()->take(6)->get());
        View::share('visionMission', VisionMission::first());  
        View::share('contactDetials', ContactDetials::first()); 
        View::share('terms', Terms::first()); 
        View::share('privacy', Privacy::first()); 
        View::share('sociallink', Sociallink::first());
       
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $notificationCount = $user->unreadNotifications->count();
                $view->with('notificationCount', $notificationCount);
            } else {
                $view->with('notificationCount', 0);
            }
        });

        View::composer('*', function ($view) {
            $walletBalance = (new WalletService())->getWalletBalance(); 
           
            $view->with('wallet', $walletBalance);
        });
       
        View::composer('*', function ($view) {
            if (!Auth::check()) {
                return $view->with([
                    'notificationCount' => 0,
                    'notificationsBar' => collect()
                ]);
            }
        
            $user = Auth::user();
            
            // Only show unread notifications in dropdown
            $notificationsBar = $user->unreadNotifications()
                ->where(function($query) use ($user) {
                    $query->where('notifiable_id', $user->id)
                          ->orWhereJsonContains('data->recipient_id', $user->recipient_id);
                })
                ->orderBy('created_at', 'desc')
                ->take(10)
                ->get();
        
            $view->with([
                'notificationCount' => $user->unreadNotifications()->count(),// Count of unread
                'notificationsBar' => $notificationsBar // Only unread notifications
            ]);
        });
        
        

    }
}
