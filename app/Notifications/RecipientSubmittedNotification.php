<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class RecipientSubmittedNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($transferDetails)
    {
        $this->transferDetails = $transferDetails;
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
    public function toDatabase($notifiable)
    {
        return [
            'notification_status' => 'Recipient Submitted Notification',
            'property_id' => $this->transferDetails['property_id'],
            'property_slug' => $this->transferDetails['property_slug'],
            'property_name' => $this->transferDetails['property_name'],
            'property_image' => $this->transferDetails['property_image'],
            'land_size' => $this->transferDetails['land_size'],
            'total_price' => $this->transferDetails['total_price'],
            'status' => $this->transferDetails['status'],
            'created_date' => now(),
            'reference' => $this->transferDetails['reference'],
            'sender_id' => $this->transferDetails['sender_id'],
            'recipient_id' => $this->transferDetails['recipient_id'],
            'property_mode' => 'transfer', 
            'message' => $notifiable->id === $this->transferDetails['sender_id']
                ? 'You have initiated a property transfer.'
                : 'You have received a property transfer.',
        ];
    }

    public function toMail($notifiable)
    {
        $message = $notifiable->id === $this->transferDetails['sender_id']
            ? 'You have initiated a property transfer.'
            : 'You have received a property transfer.';
        $formattedPrice = number_format($this->transferDetails['total_price']/100, 2);
        return (new MailMessage)
            ->subject('Property Transfer Notification')
            ->line($message)
            ->line('Property Name: ' . $this->transferDetails['property_name'])
            ->line('Land Size: ' . $this->transferDetails['land_size'] .' SQM')
            ->line('Total Price: ₦' . $formattedPrice)
            ->line('Reference: ' . $this->transferDetails['reference'])
            ->action('View Property', url('/property/' . $this->transferDetails['property_slug']))
            ->line('Thank you for using our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [ 
            'notification_status' => 'RecipientSubmittedNotification',
            'property_id' => $this->transferDetails['property_id'],
            'property_slug' => $this->transferDetails['property_slug'],
            'property_name' => $this->transferDetails['property_name'],
            'property_image' => $this->transferDetails['property_image'],
            'land_size' => $this->transferDetails['land_size'],
            'total_price' => $this->transferDetails['total_price'],
            'reference' => $this->transferDetails['reference'],
            'message' => $notifiable->id === $this->transferDetails['sender_id']
                ? 'You have initiated a property transfer.'
                : 'You have received a property transfer.',
        ];
    }
}
