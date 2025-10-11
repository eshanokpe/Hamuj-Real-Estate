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
    public function toMail($notifiable)
    {
        $formattedPrice = number_format($this->transferDetails['total_price']/100, 2);
        $user = User::find($this->transferDetails['sender_id']);
        $senderName = $user->first_name . ' ' . $user->last_name;

        return (new MailMessage)
            ->subject('Accept Your Asset Transfer')
            ->greeting('Dear ' . $notifiable->full_name . ',')
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
        $senderName = User::find($this->transferDetails['sender_id'])->first_name . ' ' . User::find($this->transferDetails['sender_id'])->last_name;
        $formattedPrice = number_format($this->transferDetails['total_price']/100, 2);
        
        return [
            'notification_status' => 'recipientSubmittedNotification',  
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
            'message' => 'You have received ₦' . $formattedPrice . ' asset transfer from ' . $senderName . '. Please accept the transfer.',
        ];
    }

    public function toArray($notifiable)
    {
        $senderName = User::find($this->transferDetails['sender_id'])->name;
        
        return [    
            'notification_status' => 'RecipientSubmittedNotification',
            'property_id' => $this->transferDetails['property_id'],
            'property_slug' => $this->transferDetails['property_slug'],
            'property_name' => $this->transferDetails['property_name'],
            'property_image' => $this->transferDetails['property_image'],
            'land_size' => $this->transferDetails['land_size'],
            'total_price' => $this->transferDetails['total_price'],
            'reference' => $this->transferDetails['reference'],
            'message' => 'You have received an asset transfer of ₦' . number_format($this->transferDetails['total_price']/100, 2) . ' from ' . $senderName . ' via Dohmayn. Please accept the transfer to complete the transaction.',
        ];
    }
}