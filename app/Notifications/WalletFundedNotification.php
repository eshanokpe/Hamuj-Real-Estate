<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class WalletFundedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $amount;
    protected $balance;

    /**
     * Create a new notification instance.
     *
     * @param float $amount
     * @param float $balance
     */
    public function __construct($amount, $balance)
    {
        $this->amount = $amount;
        $this->balance = $balance;
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
        return (new MailMessage)
            ->greeting("Hello, {$notifiable->name}")
            ->line("₦{$this->amount} has been successfully added to your wallet.")
            ->line("Your new wallet balance is ₦{$this->balance}.")
            ->action('View Wallet', route('user.wallet.index'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'notification_status' => 'Wallet Funded Notification',
            'amount' => $this->amount,
            'balance' => $this->balance,
            'message' => "₦{$this->amount} has been added to your wallet. New balance: ₦{$this->balance}.",
        ];
    }
}
