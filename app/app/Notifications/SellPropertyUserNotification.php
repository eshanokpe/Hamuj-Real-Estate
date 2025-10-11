<?php


namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
// use Illuminate\Notifications\Messages\NexmoMessage;

class SellPropertyUserNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $property;
    protected $user;
    protected $sell;
    protected $contactDetials;

    public function __construct($user, $property, $sell, $contactDetials)
    {
        $this->user = $user;
        $this->property = $property;
        $this->sell = $sell;
        $this->contactDetials = $contactDetials;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; 
        // return ['mail', 'database', 'nexmo']; 
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Thank You for Selling Your Asset with Dohmayn') 
            ->greeting("Dear {$this->user->first_name} {$this->user->last_name},")
            ->line("Thank you for choosing Dohmayn to sell your asset! We're excited to help you through this process.")
            ->line("**Property Details:**")
            ->line("• Address: {$this->property->location}")
            // ->line("• Listed Price: ₦" . number_format($this->property->price, 2))
            ->line("• Land Size: {$this->sell->selected_size_land} SQM")
            ->line("") 
            ->line("Your asset is currently being reviewed, and payment will be done shortly.")
            ->line("If you have any questions or need assistance, feel free to contact our support team at {{$this->contactDetials->first_email}} or call us at {$this->contactDetials->first_phone} {$this->contactDetials->second_phone}.")
            ->salutation("Best regards,\nDohmayn Team\nsupport@dohmayn.com\nwww.dohmayn.com");
    }

    public function toDatabase($notifiable)
    {
        return [
            'notification_status' => 'sellPropertyUserNotification',
            'title' => 'Property Sale Request Submitted',
            'message' => "You've submitted a request to sell {$this->property->name}. Our team will review it shortly.",
            'property_id' => $this->property->id,
            'user_id' => $this->user->id,
        ];
    }

    // public function toNexmo($notifiable)
    // {
    //     return (new NexmoMessage)
    //         ->content("Hi {$this->user->name}, your property '{$this->property->name}' is being reviewed. Payment will be processed shortly. - Dohmayn");
    // }
}


