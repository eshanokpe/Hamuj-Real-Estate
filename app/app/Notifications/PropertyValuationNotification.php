<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PropertyValuationNotification extends Notification
{
    use Queueable;
 
    protected $property;
    protected $percentageIncrease;

    /**
     * Create a new notification instance.
     *
     * @param $property
     * @param $percentageIncrease
     */
    public function __construct($property, $percentageIncrease)
    {
        $this->property = $property;
        $this->percentageIncrease = $percentageIncrease;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // You can include 'mail', 'sms', etc.
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        
        return (new MailMessage)
            ->subject('Exciting Update: Increased Valuation for Your Asset!')
            ->greeting('Dear ' . ($notifiable->first_name ?? 'Valued User') . ',')
            ->line('We are pleased to inform you that the valuation for the property located at ' . $this->property->location . ' has increased! This exciting news reflects the current market trends and enhanced demand in your area.')
            ->line('')
            ->line('*New Valuation Details:*')
            ->line('• *Previous Valuation:* ₦' . number_format($this->property->previous_price ?? 0, 2))
            ->line('• *New Valuation:* ₦' . number_format($this->property->price, 2))
            ->line('• *Percentage Increase:* ' . ceil($this->percentageIncrease) . '%')
            ->line('')
            ->line('This increase is a great opportunity for you if you’re considering buying or selling your asset. Our team is here to assist you with any questions or to discuss next steps.')
            ->line('')
            ->line('Thank you for being a valued member of our community. We look forward to supporting you in maximizing the potential of your asset!')
            ->salutation('Best regards,')
            ->line('[Your Contact Information]')
            ->action('View Property', url('user/my-properties/' . encrypt($this->property->slug) ));
    
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */ 
    public function toArray($notifiable)
    {
        return [  
            'notification_status' => 'propertyValuationNotification',
            'subject' => 'Exciting update: Your property valuation has increased!',
            'message' => 'We have great news for you! The valuation of your property located at {$this->property->location} has increased. This change reflects the current market trends and highlights the growing value of your investment.',
            'property_id' => $this->property->id,
            'property_location' => $this->property->location,
            'property_name' => $this->property->name,
            'previous_price' => $this->property->previous_price, 
            'market_value' => $this->property->price, 
            'percentage_increase' => ceil($this->percentageIncrease),
        ];
    }
}
