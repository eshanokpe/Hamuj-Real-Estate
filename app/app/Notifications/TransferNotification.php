<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class TransferNotification extends Notification implements ShouldQueue
{
    use Queueable;
 
    private $user; 
    private $amount;
    private $type; // "Sender" or "Recipient"
    private $propertyData;

    public function __construct($user, $amount, $type, $propertyData)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->type = $type;
        $this->propertyData = $propertyData;
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    { 
        return (new MailMessage)
            ->subject($this->getSubject()) 
            ->greeting("Dear {$notifiable->first_name} {$notifiable->last_name},")
            ->line(...$this->getMessageLines($notifiable))
            ->action('View Dashboard', url('/user/dashboard'))
            ->line('Thank you for using our platform.')
            ->salutation("Best regards,\nYour Platform Name");
    }

    public function toArray($notifiable)
    {
        return [  
            'notification_status' => 'transferNotification',
            'status' => 'accepted',
            'subject' => $this->getSubject(),
            'property_name' => $this->propertyData->property_name,
            'property_location' => $this->propertyData->property_location,
            'message' => implode("\n", $this->getMessageLines($notifiable)),
            'amount' => number_format($this->amount / 100, 2, '.', ','),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "Transfer of " . number_format($this->amount / 100, 2, '.', ',') . " was successful. {$this->type}: {$this->user->name}.",
        ]);
    }

    private function getSubject()
    {
        return $this->type === 'Sender'
            ? 'Transfer Successful - Property Asset Transaction Confirmation'
            : 'Asset Transfer Received - Property Transaction Confirmation';
    }

    private function getMessageLines($notifiable)
    {
        $propertyId = $this->propertyData->property_id ?? '[Property Number]';
        $propertyAddress = $this->propertyData->property_name ?? '[Property Address]';
        $amountFormatted = '₦' . number_format($this->amount / 100, 2);
        $date = now()->format('F j, Y, g:i A');
        $reference = $this->user->reference ?? '[Reference Number]';

        if ($this->type === 'Sender') {
            return [ 
                "Dear {$notifiable->first_name} {$notifiable->last_name},",
                "This email confirms that the transfer of assets for Property {$this->propertyData->property_name} has been successfully completed on {$date}.",
                "**Transaction Details:**",
                "•⁠  Property: {$propertyAddress}",
                "•⁠  Transaction ID: {$reference}",
                "•⁠  Amount Transferred: {$amountFormatted}",
                "•⁠  Transfer Date: {$date}",
                "The funds have been securely processed and will be reflected in your wallet.",
            ];
        } else {
            return [
                "We're pleased to inform you that the asset transfer for Property ID #{$propertyId} has been successfully received in your account.",
                "**Transaction Details:**",
                "•⁠  Property: {$propertyAddress}",
                "•⁠  Transaction ID: {$reference}",
                "•⁠  Amount Received: {$amountFormatted}",
                "•⁠  Receipt Date: {$date}",
                "•⁠  Sender: {$this->user->name}",
                "The transferred assets are now available in your asset account. You can access and manage them through your property dashboard.",
                "**Important Next Steps:**",
                "1.⁠ ⁠Review the transferred assets in your portfolio",
                "2.⁠ ⁠Verify all property details are correct",
                "3.⁠ ⁠Download transaction documents for your records",
                "To view the complete transaction details, please log into your account at https://dohmayn.com/.",
                "If you notice any discrepancies or have questions, please contact our support team within 48 hours.",
                "Thank you for choosing our platform.",
                "Best regards,"
            ];
        }
    }
}
