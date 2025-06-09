<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\WalletTransaction;

class WalletTransferNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $title;
    public $message;
    public $isSuccess;
    public $transaction;

    /**
     * Create a new notification instance.
     */
    public function __construct($title, $message, $isSuccess, $transaction = null)
    {
        $this->title = $title;
        $this->message = $message;
        $this->isSuccess = $isSuccess;
        $this->transaction = $transaction;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->subject($this->title)
                    ->line($this->message)
                    ->line('Amount: '.number_format($this->transaction?->amount ?? 0, 2))
                    ->line('Recipient: '.($this->transaction?->accountName ?? 'N/A'))
                    ->action('View Transaction', url('/wallet/transactions'))
                    ->line('Thank you for using our service!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        // return [ 
        //     'title' => $this->title,
        //     'message' => $this->message,
        //     'is_success' => $this->isSuccess,
        //     'transaction_id' => $this->transaction?->id,
        //     'amount' => $this->transaction?->amount,
        //     'recipient' => $this->transaction?->accountName,
        //     'link' => '/wallet/transactions',
        // ];

        return [
            'notification_status' => 'wallet_transfer_notification',
            'amount' => $this->transaction?->amount,
            'recipient' => $this->transaction?->accountName,
            'link' => '/wallet/transactions',
            'message' => 'You have made a transfer of NGN ' . number_format($this->transaction?->amount, 2),
        ];
    }
}