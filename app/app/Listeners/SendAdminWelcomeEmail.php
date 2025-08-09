<?php

namespace App\Listeners;

use App\Events\AdminRegistered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\AdminWelcomeEmail;
use Illuminate\Support\Facades\Mail;

class SendAdminWelcomeEmail
{

    public $connection='';
    public $queue='';
    public $delay='';

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  AdminRegistered  $event
     * @return void
     */
    public function handle(AdminRegistered $event)
    {
        $admin = $event->admin;
        Mail::to($admin)->send(new AdminWelcomeEmail($admin));
    }

    //handle failed job
    public function failed(AdminRegistered $event, $exception)
    {
        //
    }
}
