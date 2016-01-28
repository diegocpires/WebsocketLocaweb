<?php
use Ratchet\Server\IoServer;
use Ratchet\Http\HttpServer;
use Ratchet\WebSocket\WsServer;
use ServerLocaweb\WebSocketServer;

require dirname(__DIR__) . '/vendor/autoload.php';
echo 'Iniciando servidor...' . PHP_EOL;
$server = IoServer::factory(
    new HttpServer(
        new WsServer(
            new WebSocketServer()
        )
    ),
    8081
);

$server->run();