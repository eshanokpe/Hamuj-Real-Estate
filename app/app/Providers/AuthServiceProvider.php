<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Better: Share only with admin views using a composer
        View::composer('admin.*', function ($view) {
            $stats = [];
            if (Auth::guard('admin')->check()) {
                $admin = Auth::guard('admin')->user();
                $stats = [
                    'admin_name' => $admin->name,
                    'admin_email' => $admin->email,
                    'admin_avatar' => $admin->avatar, // if you have
                ];
            }
            $view->with($stats);
        });
        
    }
}
 