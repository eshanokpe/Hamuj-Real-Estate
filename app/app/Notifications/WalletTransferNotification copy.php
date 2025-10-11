<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WalletTransferNotification extends Notification
{
    use Queueable;

    protected $amount;
    protected $newBalance;

    /**
     * Create a new notification instance.
     *
     * @param float $amount
     * @param float $newBalance
     */
    public function __construct($amount, $newBalance)
    {
        $this->amount = $amount;
        $this->newBalance = $newBalance;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail', 'database']; // Choose your preferred channels: 'mail', 'database', 'slack', etc.
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
            ->subject('Wallet Funded Successfully')
            ->greeting('Hello ' . $notifiable->name . '!')
            ->line('Your wallet has been credited with NGN ' . number_format($this->amount, 2) . '.')
            ->line('Your new wallet balance is NGN ' . number_format($this->newBalance, 2) . '.')
            ->line('Thank you for using our service!');
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
            'notification_status' => 'Wallet Transfer Notification',
            'amount' => $this->amount,
            'new_balance' => $this->newBalance,
            'message' => 'Your wallet has been credited with NGN ' . number_format($this->amount, 2) .
                '. Your new balance is NGN ' . number_format($this->newBalance, 2) . '.',
        ];
    }
}
