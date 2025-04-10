<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class ReferralConnectionNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $referrer;

    public function __construct(User $referrer)
    {
        $this->referrer = $referrer;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $referrerName = e(trim($this->referrer->first_name . ' ' . $this->referrer->last_name));
        
        return (new MailMessage)
            ->subject('👋 Welcome to Our Community!')
            ->greeting('Hello ' . e($notifiable->first_name) . '!')
            ->line('You were successfully referred by ' . $referrerName . '.')
            ->line('As a referred member, you get access to our exclusive community benefits.')
            ->line('When you make your first property purchase, your referrer will earn a 3% commission.')
            ->action('Start Exploring', route('user.properties'))
            ->line('Thank you for joining us!');
    }

    public function toArray($notifiable)
    {
        $referrerName = trim($this->referrer->first_name . ' ' . $this->referrer->last_name);
        
        return [
            'notification_status' => 'referral_connection',
            'message' => 'You were referred by ' . $referrerName,
            'action_url' => route('user.properties'),
            'action_text' => 'Browse Properties'
        ];
    }
}