<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // For authenticated users (web and API)
        Broadcast::routes([
            'middleware' => ['web', 'auth:sanctum'], 
            'prefix' => 'api'
        ]);

        // For guest users (web only)
        Broadcast::routes([
            'middleware' => ['web'],
            'prefix' => 'web'
        ]);

        require base_path('routes/channels.php');
    }
}
