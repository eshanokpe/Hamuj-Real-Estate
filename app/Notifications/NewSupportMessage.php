<?php

namespace App\Notifications;

use App\Models\Message;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Str;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewSupportMessage extends Notification implements ShouldQueue
{
    use Queueable;

    public $message;

    public function __construct(Message $message)
    {
        $this->message = $message;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'content' => Str::limit($this->message->content, 100),
            'user_type' => $this->message->user_type,
            'created_at' => $this->message->created_at->toDateTimeString()
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'read_at' => null,
            'data' => $this->toArray($notifiable),
            'created_at' => now()->toDateTimeString()
        ]);
    }

    public function toArray($notifiable)
    {
        return $this->toDatabase($notifiable);
    }
}