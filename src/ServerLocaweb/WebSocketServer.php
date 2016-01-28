<?php
namespace ServerLocaweb;
use Ratchet\MessageComponentInterface;
use Ratchet\ConnectionInterface;

class WebSocketServer implements MessageComponentInterface {

    protected $clients;

    public function __construct() {
        $this->clients = new \SplObjectStorage;
        echo "Servidor Webocket no ar". PHP_EOL;
    }

    public function onOpen(ConnectionInterface $conn) 
    {
        $this->clients->attach($conn);

    	echo "Conexão estabelecida\n";
    }

    public function onMessage(ConnectionInterface $from, $msg) 
    {
    	$totalConexoes = count($this->clients) - 1;
        echo sprintf('Conexão %d enviando mensagem "%s" para %d conex%s' . PHP_EOL
            , $from->resourceId, $msg, $numRecv, $numRecv == 1 ? 'ão' : 'ões');

        foreach ($this->clients as $client) {
            if ($from !== $client) {
                $client->send($msg);
            }
        }
    }

    public function onClose(ConnectionInterface $conn) 
    {
        $this->clients->detach($conn);

        echo "Conexão {$conn->resourceId} foi desconectada".PHP_EOL;
    }

    public function onError(ConnectionInterface $conn, \Exception $e) 
    {
        echo "Ocorreu um erro: {$e->getMessage()}".PHP_EOL;

        $conn->close();
    }
}