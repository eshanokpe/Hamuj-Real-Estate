<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class TransactionOtpNotification extends Notification
{
    use Queueable;

    protected $otp;

    public function __construct($otp)
    {
        $this->otp = $otp;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Transaction Verification Code')
            ->line('Your one-time verification code is:')
            ->line('<h1 style="text-align:center;">' . $this->otp . '</h1>')
            ->line('This code will expire in 15 minutes.')
            ->line('If you did not request this code, please secure your account.');
    }
}