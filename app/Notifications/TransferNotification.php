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
    private $type;

    public function __construct($user, $amount, $type)
    {
        $this->user = $user;
        $this->amount = $amount;
        $this->type = $type; // "Sender" or "Recipient"
    }

    public function via($notifiable)
    {
        return ['mail', 'database', 'broadcast'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Property Transfer Confirmation')
            ->greeting("Hello {$notifiable->first_name} {$notifiable->last_name},")
            ->line("Your transfer request has been successfully processed.")
            ->line("**Amount:** " . number_format($this->amount / 100, 2, '.', ','))
            ->line("**{$this->type}:** {$this->user->name} ({$this->user->email})")
            ->action('View Details', url('/user/dashboard'))
            ->line('Thank you for using our service!');
    }

    public function toArray($notifiable)
    {
        return [
            'notification_status' => 'transferNotification',
            'status' => 'accepted',
            'message' => "Transfer of Property Asset was successful. {$this->type}: {$this->user->name}",
            'amount' => number_format($this->amount / 100, 2, '.', ','),
            // 'url' => url('/user/dashboard')
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'message' => "Transfer of " . number_format($this->amount / 100, 2,  '.', ',') ." was successful. {$this->type}: {$this->user->name}.",
        ]);
    }
}
