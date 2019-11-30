<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use Ramsey\Uuid\Uuid;

/**
 * Inicia a conexão
 */
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

/**
 * Declara qual a fila que será usada
 */
$channel->queue_declare('hello', false, false, false, false);

$a = 1;
while ($a <= 1000) {
    $json = json_encode([
        'message' => $a,
        'uuid' => Uuid::uuid4()
    ]);
    
    /**
     * Cria a nova mensagem
     */
    $msg = new AMQPMessage($json);
    
    /**
     * Envia para a fila
     */
    $channel->basic_publish($msg, '', 'hello');

    echo " [x] Publish ", $a, "\n";
    
    $a++;
}

/**
 * Encerra conexão
 */
$channel->close();
$connection->close();