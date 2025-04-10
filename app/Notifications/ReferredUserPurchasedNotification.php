<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;
use App\Models\Property;

class ReferredUserPurchasedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $referrer;
    protected $property;

    /**
     * Create a new notification instance.
     *
     * @param User $referrer
     * @param Property $property
     */
    public function __construct(User $referrer, Property $property)
    {
        $this->referrer = $referrer;
        $this->property = $property;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $referrerName = e(trim($this->referrer->first_name . ' ' . $this->referrer->last_name));
        
        return (new MailMessage)
            ->subject(config('app.name') . ' - Your Referrer Earned Commission!')
            ->greeting('Hello ' . e($notifiable->first_name) . ',')
            ->line('We wanted to let you know that because you were referred by ' . $referrerName . ',')
            ->line('they have earned a referral commission from your first property purchase.')
            ->line('Here are the details:')
            ->line('') // Empty line before table
            ->line('**Referrer:** ' . $referrerName)
            ->line('**Property:** ' . e($this->property->name))
            ->line('**Your Benefit:** You helped someone earn while making your own smart investment!')
            ->action('View Your Purchase', route('user.purchases'))
            ->line('Thank you for being part of our community!')
            ->salutation('Best Regards,<br>' . config('app.name'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        $referrerName = trim($this->referrer->first_name . ' ' . $this->referrer->last_name);
        
        return [
            'notification_status' => 'referred_purchase',
            'referrer_id' => $this->referrer->id,
            'referrer_name' => $referrerName,
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'message' => 'Your referrer ' . $referrerName . ' earned commission from your purchase',
            'action_url' => route('user.purchases'),
            'action_text' => 'View Purchases',
            'created_at' => now()->toDateTimeString()
        ];
    }

    /**
     * Get the notification's tags for Horizon.
     *
     * @return array
     */
    public function tags()
    {
        return ['referral', 'purchase', 'user:' . $this->referrer->id];
    }
}