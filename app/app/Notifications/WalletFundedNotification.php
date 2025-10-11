<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\Carbon;

class WalletFundedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $amount;
    protected $balance;
    protected $reference; 

    /**
     * Create a new notification instance.
     *
     * @param float $amount
     * @param float $balance 
     * @param string $$reference
     */
    public function __construct($amount, $balance, $reference)
    {
        $this->amount = $amount;
        $this->balance = $balance;
        $this->reference = $reference;
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
        $formattedAmount = number_format($this->amount, 2);
        $formattedBalance = number_format($this->balance, 2);
        $formattedDate = Carbon::now()->format('F j, Y, g:i A');

        return (new MailMessage)
            ->subject('Your Wallet Has Been Credited!')
            ->greeting("Dear {$notifiable->first_name} {$notifiable->last_name},")
            ->line('We are excited to inform you that your wallet has been credited with funds, ready for you to use on Dohmayn!')
            ->line('')
            ->line('*Transaction Details:*')
            ->line('•⁠  ⁠*Amount Credited:* ₦' . $formattedAmount)
            ->line('•⁠  ⁠*Transaction ID:* ' . $this->reference)
            ->line('•⁠  ⁠*Date:* ' . $formattedDate)
            ->line('')
            ->line('You can now utilize these funds to purchase assets listed on our platform. Explore our latest offerings and make your next investment today!')
            ->line('')
            ->line('If you have any questions or require assistance, please don’t hesitate to reach out to our support team.')
            ->line('')
            ->line('Happy property hunting!')
            ->salutation('Best regards, Dohmayn Support Team');
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
            'notification_status' => 'walletFundedNotification',
            'subject' => 'Your Wallet Has Been Credited!',
            'amount' => number_format($this->amount, 2),
            'balance' => number_format($this->balance, 2),
            'transaction_id' => $this->reference,
            'date' => now()->toDateTimeString(),
            'message' => '₦' . number_format($this->amount, 2) . ' has been added to your wallet. New balance: ₦' . number_format($this->balance / 100, 2) . '.',
        ];
    }
}
