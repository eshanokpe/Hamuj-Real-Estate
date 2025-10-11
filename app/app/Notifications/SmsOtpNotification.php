<?php

namespace App\Notifications;

use App\Channels\SmsChannel;  // Explicitly import the channel
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SmsOtpNotification extends Notification implements ShouldQueue
{
    use Queueable;
 
    protected $otp;  // Changed to protected for better encapsulation

    public function __construct(string $otp)  // Added type hint
    {
        $this->otp = $otp; 
    }

    public function via($notifiable): array  // Added return type
    {
        return [SmsChannel::class];
    }
 
    public function toSms($notifiable): string  // Added return type
    {
        return "DO NOT DISCLOSE. Dear Customer,\n"
             . "The code for your phone number authentication is: " . $this->otp . " \n"
             . "No Staff of Dohmayn will ask for this code!\n"
             . "Valid for 15 minutes. Do not share to anyone!.\n"
             . config('app.name');  // Adds your app name for identification
    } 
    // {$this->otp} 
    // Optional: For Laravel's on-demand notifications
    public function toArray($notifiable): array
    {
        return [
            'otp' => $this->otp,
            'expires_in' => '15 minutes'
        ];
    }
}