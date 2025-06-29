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
        return "Your verification code is: {$this->otp}\n"
             . "Valid for 15 minutes. Do not share this code.\n"
             . config('app.name');  // Adds your app name for identification
    }

    // Optional: For Laravel's on-demand notifications
    public function toArray($notifiable): array
    {
        return [
            'otp' => $this->otp,
            'expires_in' => '15 minutes'
        ];
    }
}