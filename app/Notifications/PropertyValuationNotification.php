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
            ->subject('Property Valuation Update')
            ->line('The valuation for property ' . $this->property->name . ' has been updated.')
            ->line('Market Value: ₦' . number_format($this->property->price, 2))
            ->line('Percentage Increase: ' . $this->percentageIncrease . '%')
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
            'property_id' => $this->property->id,
            'property_name' => $this->property->name,
            'market_value' => $this->property->price,
            'percentage_increase' => ceil($this->percentageIncrease),
        ];
    }
}
