<?php

namespace App\Providers;
use App\Services\WalletService;
use function App\Helpers\getWalletBalance;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap(); 
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
            // or
            // $walletBalance = getWalletBalance(); 

            $view->with('wallet', $walletBalance);
        //     if (Auth::check()) {
        //         $wallet = Auth::user()->wallet;
        //         $balance = $wallet ? $wallet->balance : 0;
        //         $view->with('wallet', $wallet);
        //     } else {
        //         $view->with('wallet', 0);
        //     }
        }); 
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $user = Auth::user();
                $userId = (string) $user->id; 
                $recipientId = $user->recipient_id;
          
                $sender = $user->notifications()->whereJsonContains('data->recipient_id', $recipientId)->first();
                
                $sender_id = $sender ? $sender->data['sender_id'] : null;
        
                $notifications = $user->notifications()
                    ->where('notifiable_id', $sender_id)  
                    ->orWhereJsonContains('data->recipient_id', $recipientId) 
                    ->orderBy('created_at', 'desc') 
                    ->take(4) 
                    ->get();
        
                $view->with('notificationsBar', $notifications);
            } else {
                $view->with('notificationsBar', 0);
            }
        });
        
        

    }
}
