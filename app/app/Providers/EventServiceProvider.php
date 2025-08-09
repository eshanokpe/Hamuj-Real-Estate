<?php

namespace App\Providers;

// use Illuminate\Auth\Events\Registered;
// use Illuminate\Auth\Listeners\SendEmailVerificationNotification;

use App\Events\AdminRegistered;
use App\Listeners\SendAdminWelcomeEmail;
use App\Events\VoterRegistered;
use App\Listeners\SendVoterWelcomeEmail;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Registered::class => [
        //     SendEmailVerificationNotification::class,
        // ],
        AdminRegistered::class => [
            SendAdminWelcomeEmail::class,
        ],
        VoterRegistered::class => [
            SendvoterWelcomeEmail::class,
        ]

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
