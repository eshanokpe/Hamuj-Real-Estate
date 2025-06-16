<?php

// app/Events/AdminReplied.php
namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class AdminReplied implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public $userId;
    public $isGuest;

    public function __construct($message, $userId, $isGuest = true)
    {
        $this->message = $message;
        $this->userId = $userId;
        $this->isGuest = $isGuest;
    }

    public function broadcastOn()
    {
        if ($this->isGuest) {
            return new Channel('guest.' . $this->userId);
        }
        return new Channel('user.' . $this->userId);
    }
    
    public function broadcastAs()
    {
        return 'admin-replied';
    }
    
    public function broadcastWith()
    {
        return [
            'message' => [
                'content' => $this->message->content,
                'created_at' => $this->message->created_at->format('h:i A'),
                'user_type' => $this->message->user_type
            ]
        ];
    }
}