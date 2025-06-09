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

    public function __construct($title, $message, $isSuccess, WalletTransaction $transaction)
    {
        $this->title = $title;
        $this->message = $message;
        $this->isSuccess = $isSuccess;
        $this->transaction = $transaction;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->title)
            ->greeting('Hello ' . $notifiable->full_name . ',')
            ->line($this->message)
            ->line('Transaction Details:')
            ->line('Amount: ₦' . number_format($this->transaction->amount, 2))
            ->line('Recipient: ' . $this->transaction->accountName)
            ->line('Bank: ' . $this->transaction->bankName)
            ->line('Reference: ' . ($this->transaction->metadata['reference'] ?? 'N/A'))
            ->line('Status: ' . ucfirst($this->transaction->status))
            ->action('View Transaction', route('user.transactions.show', $this->transaction->id))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
            'type' => 'transfer',
            'transaction_id' => $this->transaction->id,
            'amount' => $this->transaction->amount,
            'recipient' => $this->transaction->accountName,
            'bank' => $this->transaction->bankName,
            'status' => $this->transaction->status,
            'reference' => $this->transaction->metadata['reference'] ?? null,
            'transfer_code' => $this->transaction->transfer_code,
            'link' => route('user.wallet.show', $this->transaction->id),
            'timestamp' => now()->toDateTimeString(),
        ];
    }
}