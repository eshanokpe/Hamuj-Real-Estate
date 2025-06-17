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
        return ['database', 'broadcast','mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('New Support Message Received')
            ->line('You have received a new support message.')
            ->line('From: ' . $this->getSenderName())
            ->line('Message: ' . $this->message->content)
            ->action('View Conversation', $this->getConversationUrl())
            ->line('Thank you for using our application!');
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

    public function toArray(object $notifiable): array
    {
        return [
            'message_id' => $this->message->id,
            'conversation_id' => $this->message->conversation_id,
            'content' => Str::limit($this->message->content, 100),
            'sender_type' => $this->message->user_type,
            'sender_name' => $this->getSenderName(),
            'link' => $this->getConversationUrl(),
            'created_at' => $this->message->created_at->toDateTimeString()
        ];
    }

     protected function getSenderName(): string
    {
        if ($this->message->user_type === 'guest') {
            return 'Guest User';
        }

        return $this->message->user->name ?? 'Registered User';
    }

    protected function getConversationUrl(): string
    {
        return route('admin.conversations.show', $this->message->conversation_id);
    }
}