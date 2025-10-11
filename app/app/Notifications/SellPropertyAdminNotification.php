<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class SellPropertyAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $user;
    protected $sell;
    protected $property;

    public function __construct($user, $property, $sell)
    {
        $this->user = $user;
        $this->sell = $sell;
        $this->property = $property;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $phone = $this->user->phone ?? 'N/A';
        return (new MailMessage)
            ->subject('New Asset Sell Request')
            ->greeting('Dear Platform Team,')
            ->line("We have received a new request from a user wishing to sell their assets.")
            ->line("**User Information:**")
            ->line("• Name:  {$this->user->first_name} {$this->user->last_name}")
            ->line("• Email: {$this->user->email}")
            ->line("• Phone: {$phone}")
            ->line("")
            ->line("**Property Details:**")
            ->line("• Address: {$this->property->location}")
            ->line("• Listed Price: ₦" . number_format($this->property->valuationSummary->current_value_sum, 2))
            ->line("• Land Size: {$this->sell->selected_size_land} SQM")
            ->line("")
            ->line("Please review the submitted information and proceed with the necessary steps to verify and list the property on our platform.")
            ->salutation("Best regards,\nAdmin\nDohmayn");
    }
}

