<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Property;

class ReferralCommissionEarnedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $referredUser;
    protected $property;
    protected $amount;
    protected $commissionPercentage = 3; // 3% commission

    public function __construct(User $referredUser, Property $property, float $amount)
    {
        $this->referredUser = $referredUser;
        $this->property = $property;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $referredUserName = e(trim($this->referredUser->first_name . ' ' . $this->referredUser->last_name));
        $purchaseAmount = $this->amount / ($this->commissionPercentage / 100);
        $walletBalance = $notifiable->wallet->balance ?? 0;
        $currency = config('app.currency', '₦'); // Default to Naira if not set

        return (new MailMessage)
            ->subject(config('app.name', 'Our App') . ' - Referral Commission Earned!')
            ->greeting('Congratulations ' . e($notifiable->first_name) . '!')
            ->line('You have earned a ' . $this->commissionPercentage . '% referral commission from ' . $referredUserName . '\'s first property purchase.')
            ->line('') // Empty line before details
            ->line('**Details of Your Commission**')
            ->line('') // Spacing
            ->line('**Referred User:** ' . $referredUserName)
            ->line('**Property Purchased:** ' . e($this->property->name))
            ->line('**Purchase Amount:** ' . $currency . number_format($purchaseAmount, 2))
            ->line('**Commission Rate:** ' . $this->commissionPercentage . '%')
            ->line('**Commission Earned:** ' . $currency . number_format($this->amount, 2))
            ->line('**New Wallet Balance:** ' . $currency . number_format($walletBalance + $this->amount, 2))
            ->action('View Your Referral Dashboard', route('user.referrals'))
            ->line('Thank you for referring quality users to our platform!')
            ->salutation('Best Regards,<br>' . config('app.name', 'Our Team'));
    }

    public function toArray($notifiable)
    {
        $referredUserName = trim($this->referredUser->first_name . ' ' . $this->referredUser->last_name);
        $purchaseAmount = $this->amount / ($this->commissionPercentage / 100);
        $currency = config('app.currency', '₦');

        return [
            'notification_status' => 'referral_commission',
            'referred_user_id' => $this->referredUser->id,
            'referred_user_name' => $referredUserName,
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'purchase_amount' => $purchaseAmount,
            'commission_amount' => $this->amount,
            'commission_percentage' => $this->commissionPercentage,
            'message' => 'You earned ' . $currency . number_format($this->amount, 2) . 
                        ' (' . $this->commissionPercentage . '%) from ' . $referredUserName . '\'s purchase',
            'action_url' => route('user.referrals'),
            'action_text' => 'View Referrals',
            'created_at' => now()->toDateTimeString()
        ];
    }

    public function tags()
    {
        return ['referral', 'commission', 'user:' . $this->referredUser->id];
    }
}