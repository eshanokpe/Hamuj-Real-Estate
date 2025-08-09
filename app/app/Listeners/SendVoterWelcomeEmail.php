<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\VoterRegistered;
use App\Mail\VoterWelcomeEmail;
use Illuminate\Support\Facades\Mail;

class SendVoterWelcomeEmail implements ShouldQueue
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
     * @param  VoterRegistered  $event
     * @return void
     */
    public function handle(VoterRegistered $event)
    {
        $voter = $event->voter;
        Mail::to($voter->email)->send(new VoterWelcomeEmail($voter));
    }

    //handle failed job
    public function failed(VoterRegistered $event, $exception)
    {
        //
    }
}
