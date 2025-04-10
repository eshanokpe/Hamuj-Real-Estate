<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SenderTransferNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $details;

    /**
     * Create a new notification instance.
     *
     * @param array $details
     */
    public function __construct($details)
    {
        $this->details = $details;
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
        $formattedPrice = number_format($this->details['total_price']/100, 2);

        return (new MailMessage)
            ->subject('Property Transfer Initiated')
            ->line('You have successfully initiated a property transfer.')
            ->line('Property Name: ' . $this->details['property_name'])
            ->line('Land Size: ' . $this->details['land_size'] .' SQM')
            ->line('Total Price: ₦' . $formattedPrice)
            ->line('Reference: ' . $this->details['reference'])
            ->line('Thank you for using our service!');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
            'notification_status' => 'Sender Transfer Notification',
            'property_name' => $this->details['property_name'],
            'land_size' => $this->details['land_size'],
            'total_price' => $this->details['total_price'],
            'reference' => $this->details['reference'],
            'status' => $this->details['status'],
        ];
    }
}
