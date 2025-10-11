<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Models\Message;
use App\Models\User;

class NewSupportMessageMail extends Mailable
{
    use Queueable, SerializesModels;

    public $message;
    public $admin;

    public function __construct(Message $message, User $admin)
    {
        $this->message = $message;
        $this->admin = $admin;
    }

    public function build()
    {
        return $this->subject('New Support Message Received')
                    ->view('emails.new_support_message')
                    ->with([
                        'message' => $this->message,
                        'admin' => $this->admin
                    ]);
    }
}