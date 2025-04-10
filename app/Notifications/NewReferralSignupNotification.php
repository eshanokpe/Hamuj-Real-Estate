<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewReferralSignupNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $newUser;

    public function __construct(User $newUser)
    {
        $this->newUser = $newUser;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $newUserName = e(trim($this->newUser->first_name . ' ' . $this->newUser->last_name));
        
        return (new MailMessage)
            ->subject('🎉 New Referral Signup!')
            ->greeting('Hello ' . e($notifiable->first_name) . '!')
            ->line('Congratulations! ' . $newUserName . ' just signed up using your referral link.')
            ->line('You will earn 3% commission when they make their first property purchase.')
            ->action('View Your Referrals', route('user.referrals.show'))
            ->line('Thank you for growing our community!');
    }

    public function toArray($notifiable)
    {
        $newUserName = trim($this->newUser->first_name . ' ' . $this->newUser->last_name);
        
        return [
            'notification_status' => 'new_referral',
            'message' => $newUserName . ' signed up using your referral',
            'action_url' => route('user.referrals.show'),
            'action_text' => 'View Referrals'
        ];
    }
}