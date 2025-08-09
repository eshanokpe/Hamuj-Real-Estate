<?php

namespace App\WebSockets;

use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;
use SplObjectStorage;

class Chat implements MessageComponentInterface
{
    protected $clients;
    protected $channels;

    public function __construct()
    {
        $this->clients = new SplObjectStorage;
        $this->channels = [];
    }

    public function onOpen(ConnectionInterface $conn)
    {
        $this->clients->attach($conn);
        echo "New connection! ({$conn->resourceId})\n";
    }

    public function onMessage(ConnectionInterface $from, $msg)
    {
        $data = json_decode($msg, true);
        
        if ($data['type'] === 'subscribe') {
            $channel = 'chat' . $data['chat_id'];
            if (!isset($this->channels[$channel])) {
                $this->channels[$channel] = [];
            }
            $this->channels[$channel][$from->resourceId] = $from;
            $from->send(json_encode(['status' => 'subscribed', 'channel' => $channel]));
            return;
        }

        if ($data['type'] === 'message') {
            $channel = 'chat' . $data['chat_id'];
            if (isset($this->channels[$channel])) {
                foreach ($this->channels[$channel] as $client) {
                    if ($client !== $from) {
                        $client->send(json_encode([
                            'type' => 'message',
                            'message' => $data['message'],
                            'sender' => $data['sender'],
                            'name' => $data['name'] ?? 'Admin'
                        ]));
                    }
                }
            }
            return;
        }
    }

    public function onClose(ConnectionInterface $conn)
    {
        $this->clients->detach($conn);
        foreach ($this->channels as $channel => $clients) {
            if (isset($clients[$conn->resourceId])) {
                unset($this->channels[$channel][$conn->resourceId]);
            }
        }
        echo "Connection {$conn->resourceId} has disconnected\n";
    }

    public function onError(ConnectionInterface $conn, \Exception $e)
    {
        echo "An error has occurred: {$e->getMessage()}\n";
        $conn->close();
    }
}