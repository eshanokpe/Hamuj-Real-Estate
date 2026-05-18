<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class RecipientSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $transferDetails;
 
    public function __construct($transferDetails)
    {
        $this->transferDetails = $transferDetails;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; 
    }

    public function toMail($notifiable)
    {
        $formattedPrice = number_format($this->transferDetails['total_price']/100, 2);
        
        // FIXED: Add null check for sender
        $user = User::find($this->transferDetails['sender_id']);
        $senderName = $user ? ($user->first_name . ' ' . $user->last_name) : 'A Dohmayn User';

        return (new MailMessage)
            ->subject('Accept Your Asset Transfer')
            ->greeting('Dear ' . ($notifiable->full_name ?? $notifiable->first_name ?? 'User') . ',')
            ->line('You have received an asset transfer of *₦' . $formattedPrice . '* from *' . $senderName . '* via Dohmayn. To complete the transaction, please follow the steps below to accept the transfer:')
            ->line('') 
            ->line('1. *Log in* to your Dohmayn account')
            ->line('2. Navigate to the *Transfers* section')
            ->line('3. Locate the pending transfer from *' . $senderName . '*')
            ->line('4. Click on *Accept* to confirm the transfer')
            ->line('')
            ->line('If you do not accept the transfer within *48 hours*, the asset will be returned to the sender.')
            ->line('')
            ->line('If you have any questions or need assistance, feel free to contact our support team.')
            ->line('')
            ->line('Thank you for using Dohmayn!')
            ->salutation('Best regards,<br>Dohmayn Support Team');
    }
 
    public function toDatabase($notifiable)
    {
        // FIXED: Add null check for sender
        $sender = User::find($this->transferDetails['sender_id']);
        $senderName = $sender ? ($sender->first_name . ' ' . $sender->last_name) : 'A Dohmayn User';
        
        $formattedPrice = number_format($this->transferDetails['total_price']/100, 2);
        
        return [
            'notification_status' => 'recipientSubmittedNotification',  
            'property_id' => $this->transferDetails['property_id'] ?? null,
            'property_slug' => $this->transferDetails['property_slug'] ?? null,
            'property_name' => $this->transferDetails['property_name'] ?? null,
            'property_image' => $this->transferDetails['property_image'] ?? null,
            'land_size' => $this->transferDetails['land_size'] ?? null,
            'total_price' => $this->transferDetails['total_price'] ?? 0,
            'status' => $this->transferDetails['status'] ?? 'pending',
            'created_date' => now(),
            'reference' => $this->transferDetails['reference'] ?? null,
            'sender_id' => $this->transferDetails['sender_id'] ?? null,
            'recipient_id' => $this->transferDetails['recipient_id'] ?? null,
            'property_mode' => 'transfer', 
            'message' => 'You have received ₦' . $formattedPrice . ' asset transfer from ' . $senderName . '. Please accept the transfer.',
        ];
    }

    public function toArray($notifiable)
    {
        // FIXED: Add null check for sender
        $sender = User::find($this->transferDetails['sender_id']);
        $senderName = $sender ? $sender->name : 'A Dohmayn User';
        
        return [    
            'notification_status' => 'RecipientSubmittedNotification',
            'property_id' => $this->transferDetails['property_id'] ?? null,
            'property_slug' => $this->transferDetails['property_slug'] ?? null,
            'property_name' => $this->transferDetails['property_name'] ?? null,
            'property_image' => $this->transferDetails['property_image'] ?? null,
            'land_size' => $this->transferDetails['land_size'] ?? null,
            'total_price' => $this->transferDetails['total_price'] ?? 0,
            'reference' => $this->transferDetails['reference'] ?? null,
            'message' => 'You have received an asset transfer of ₦' . number_format(($this->transferDetails['total_price'] ?? 0)/100, 2) . ' from ' . $senderName . ' via Dohmayn. Please accept the transfer to complete the transaction.',
        ];
    }
}