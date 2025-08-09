<?php

namespace App\Notifications;

use App\Models\Buy;
use App\Models\Transaction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class BuyPropertiesNotification extends Notification
{
   
    public function __construct(Transaction $transaction, Buy $buy)
    {
        $this->transaction = $transaction;
        $this->buy = $buy;
    }

    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Congratulations on Your New Asset')
            ->greeting('Dear ' . $notifiable->first_name . ',')
            ->line('I hope you\'re doing well!')
            ->line('Congratulations on your recent purchase of **' . $this->transaction->metadata['property_name'] . '**! We are thrilled to have assisted you in acquiring this fantastic asset and are confident that it will bring you joy and investment success.')
            ->line('If you have any questions, please don’t hesitate to reach out. We\'re here to help!')
            ->line('Additionally, if you could take a moment to share your experience with us, we would greatly appreciate your feedback. It helps us enhance our services for future users.')
            ->line('Thank you once again for choosing ' . config('app.name') . '. We look forward to staying in touch!')
            ->salutation('Best regards, Dohmayn Support Team');
    }

    public function toArray($notifiable)
    {
        return [
            'notification_status' => 'buyProperty',
            'title' => 'Buy Property Payment Successful',
            'property_name' => $this->transaction->metadata['property_name'], 
            'message' => 'Your payment for ' . $this->transaction->metadata['property_name'] . ' was successful.',
            'amount' => $this->transaction->amount,
            'reference' => $this->transaction->reference,
        ];
    }
}

