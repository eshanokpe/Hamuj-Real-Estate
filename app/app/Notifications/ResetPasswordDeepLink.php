<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ResetPasswordDeepLink extends Notification
{
    public function __construct(protected string $token) {}

    public function via($notifiable): array
    {
        return ['mail'];
    }

    public function toMail($notifiable): MailMessage
    {
        // Web route that validates then redirects to app deep link
        $url = url("/reset-password/{$this->token}?email=" . urlencode($notifiable->email));

        return (new MailMessage)
            ->subject('Reset Your Dohmayn Password')
            ->greeting("Hello {$notifiable->first_name},")
            ->line('You requested a password reset for your Dohmayn account.')
            ->action('Reset Password', $url)
            ->line('This link expires in **60 minutes**.')
            ->line('If you did not request this, please ignore this email and your password will remain unchanged.')
            ->salutation('The Dohmayn Team');
    }
}