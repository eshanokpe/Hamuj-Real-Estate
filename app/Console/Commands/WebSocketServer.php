<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use App\WebSockets\Chat;

class WebSocketServer extends Command
{
    protected $signature = 'websocket:serve';
    protected $description = 'Start the WebSocket server';

    public function handle()
    {
        $port = env('WEBSOCKET_PORT', 6001);
        $server = IoServer::factory(
            new HttpServer(
                new WsServer(
                    new Chat()
                )
            ),
            $port
        );

        $this->info("WebSocket server started on port {$port}");
        $server->run();
    }
}