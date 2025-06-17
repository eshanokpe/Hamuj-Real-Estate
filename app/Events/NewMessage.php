<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
 
class NewMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $isAdminMessage;

    public function __construct($message, $isAdminMessage = false)
    {
        $this->message = $message;
        $this->isAdminMessage = $isAdminMessage;
    }

    public function broadcastOn()
    {
        $channels = [
            new PrivateChannel('private-conversation.' . $this->message->conversation_id)
        ];

        // Add user-specific channel if not an admin message
        if (!$this->isAdminMessage) {
            $userChannel = $this->message->user_type === 'guest' 
                ? 'private-guest.' . $this->message->user_id
                : 'private-user.' . $this->message->user_id;
            $channels[] = new PrivateChannel($userChannel);
        }

        return $channels;
    }

    public function broadcastAs()
    {
        return 'App\\Events\\NewMessage';
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
                'conversation_id' => $this->message->conversation_id,
                'is_admin' => $this->isAdminMessage,
                'read' => $this->message->read
            ]
        ];
    }
}