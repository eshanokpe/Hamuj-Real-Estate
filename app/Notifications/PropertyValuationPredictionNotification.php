<?php

namespace App\Notifications;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notification;
 
class PropertyValuationPredictionNotification extends Notification
{
    use Queueable;

    protected $property;
    protected $percentageIncrease;
    protected $marketValue;

    /**
     * Create a new notification instance.
     *
     * @param $property
     * @param $percentageIncrease
     */
    public function __construct($property, $percentageIncrease, $marketValue, $propertyValuationPrediction)
    {
        $this->property = $property;
        $this->marketValue = $marketValue;
        $this->percentageIncrease = $percentageIncrease;
        $this->propertyValuationPrediction = $propertyValuationPrediction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; 
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
            ->subject('Upward Revision: Asset Valuation Update for ' . $this->property->name)
            ->greeting('Dear ' . ($notifiable->first_name ?? 'Valued Client') . ',')
            ->line('I trust this email finds you well. I am writing to inform you about a positive adjustment to our valuation forecast for ' . $this->property->name . '.')
            ->line('')
            ->line('Based on our latest analysis, we have revised the projected valuation upward from ₦' . number_format($this->propertyValuationPrediction['current_price'], 2) . ' to ₦' . number_format($this->propertyValuationPrediction['future_market_value'], 2) . ', representing a ' . ceil($this->percentageIncrease) . '% increase. This revision reflects:')
            ->line('')
            ->line('• Strong market performance')
            ->line('• Improved operational metrics')
            ->line('• Favorable industry conditions')
            ->line('')
            ->line('Our team remains available to discuss these updates in detail. You may schedule a call to review the underlying assumptions and implications.')
            ->action('View Property', url('user/my-properties/' . encrypt($this->property->slug)))
            ->salutation("Best regards,\nDohmayn");
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
            'notification_status' => 'propertyValuationPredictionNotification',
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'current_market_value' => number_format($this->propertyValuationPrediction['current_price'], 2),
            'future_market_value' => number_format($this->propertyValuationPrediction['future_market_value'], 2),
            'future_date' => \Carbon\Carbon::parse($this->propertyValuationPrediction['future_date'])->format('d F, Y'),
            'percentage_increase' => ceil($this->percentageIncrease),
            'message' => 'Based on our latest analysis, we have revised the projected valuation upward from ₦' . number_format($this->propertyValuationPrediction['current_price'], 2) 
                        . ' to ₦' . number_format($this->propertyValuationPrediction['future_market_value'], 2)
                        . ', representing a ' . ceil($this->percentageIncrease) . '% increase. This revision reflects strong market performance, improved operational metrics, and favorable industry conditions.',
        ];
    } 
}
