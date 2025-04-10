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
            ->subject('Property Valuation Prediction Update')
            ->line('The valuation prediction for property ' . $this->property->name . ' has been updated.')
            ->line('Market Value: ₦' . number_format($this->propertyValuationPrediction['current_price'], 2))
            ->line('Future Market Value: ₦' . number_format($this->propertyValuationPrediction['future_market_value'], 2))
            ->line('Future Date: ' . \Carbon\Carbon::parse($this->propertyValuationPrediction['future_date'])->format('d F, Y'))
            ->line('Percentage Increase: ' . ceil($this->propertyValuationPrediction['percentage_increase']) . '%')
            ->action('View Property', url('user/properties/' . $this->property->id))
            ->line('Thank you for using our platform!');
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
            'notification_status' => 'Property Valuation Prediction Notification',
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'current_market_value' => $this->propertyValuationPrediction['current_price'],
            'future_market_value' => $this->propertyValuationPrediction['future_market_value'],
            'future_date' => \Carbon\Carbon::parse($this->propertyValuationPrediction['future_date'])->format('d F, Y'),
            'percentage_increase' => ceil($this->percentageIncrease),
        ];
    } 
}
