<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $conversationId;
    public $isAdminMessage;

    public function __construct($message, $isAdminMessage = false)
    {
        $this->message = $message;
        $this->conversationId = $message->conversation_id;
        $this->isAdminMessage = $isAdminMessage;
    }

    public function broadcastOn()
    {
        return [
            new Channel('conversation.' . $this->conversationId),
            new Channel($this->message->user_type === 'guest' 
                ? 'private-guest.' . $this->message->user_id
                : 'private-user.' . $this->message->user_id)
        ];
    }

    public function broadcastAs()
    {
        return 'new-message';
    }

    public function broadcastWith()
    {
        return [
            'message' => [
                'id' => $this->message->id,
                'content' => $this->message->content,
                'created_at' => $this->message->created_at->toDateTimeString(),
                'user_type' => $this->message->user_type,
                'user_id' => $this->message->user_id,
                'is_admin' => $this->isAdminMessage
            ]
        ];
    }
}