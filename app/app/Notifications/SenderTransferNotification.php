<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SenderTransferNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $details;

    public function __construct($details)
    {
        $this->details = $details;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        $formattedPrice = number_format($this->details['total_price']/100, 2);
        
        // FIXED: Add null check for recipient
        $user = User::find($this->details['recipient_id']);
        $recipientName = $user ? ($user->first_name . ' ' . $user->last_name) : 'the recipient';

        return (new MailMessage) 
            ->subject('Asset Transfer Pending: Action Required by Receiver')
            ->greeting('Dear ' . ($notifiable->full_name ?? $notifiable->first_name ?? 'User') . ',')
            ->line('Thank you for using Dohmayn! You have successfully initiated an asset transfer of *₦' . $formattedPrice . '* to *' . $recipientName . '*.')
            ->line('')
            ->line('Please note that the transfer is currently pending acceptance by the recipient. They will need to log in to their Dohmayn account and accept the transfer to complete the transaction.')
            ->line('')
            ->line('Here are the details of your transfer:')
            ->line('')
            ->line('• *Amount:* ₦' . $formattedPrice)
            ->line('• *Receiver:* ' . $recipientName)
            ->line('• *Transfer ID:* ' . ($this->details['reference'] ?? 'N/A'))
            ->line('')
            ->line('If the receiver does not accept the transfer within *48 hours*, the funds will be automatically returned to your account.')
            ->line('')
            ->line('If you have any questions or need assistance, please feel free to reach out to our support team.')
            ->line('')
            ->line('Thank you for choosing Dohmayn!')
            ->salutation('Best regards, Dohmayn Support Team');
    }

    public function toDatabase($notifiable)
    {
        // FIXED: Add null check for recipient
        $user = User::find($this->details['recipient_id'] ?? null);
        $recipientName = $user ? ($user->first_name . ' ' . $user->last_name) : 'Unknown Recipient';
        
        return [
            'notification_status' => 'senderTransferNotification',
            'property_name' => $this->details['property_name'] ?? null,
            'land_size' => $this->details['land_size'] ?? null,
            'total_price' => ($this->details['total_price'] ?? 0) / 100,
            'reference' => $this->details['reference'] ?? null,
            'status' => $this->details['status'] ?? 'pending',
            'recipientName' => $recipientName, 
            'message' => 'You have initiated a property transfer. Please wait for recipient to accept.',
        ];
    }
}