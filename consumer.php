<?php

require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;


/**
 * Inicia a conexão
 */
$connection = new AMQPStreamConnection('localhost', 5672, 'guest', 'guest');
$channel = $connection->channel();

/**
 * Declara qual a fila que será usada
 */
$channel->queue_declare('hello', false, false, false, false);

echo ' [*] Waiting for messages. To exit press CTRL+C', "\n";

/**
 * Função que vai receber e tratar efetivamente a mensagem
 */
$callback = function($msg) {
    $json = json_decode($msg->body);
    $number = $json->message;

    echo " [x] Received ", $msg->body, "\n";
    
    $number = $number + 1000;

    echo " [x] Wait...\n";

    sleep(rand(1, 2));

    echo " [x] Result ", $number, "\n";
};

/**
 * Adiciona esse "callback" para a fila 
 */
$channel->basic_consume('hello', '', false, true, false, false, $callback);

/**
 * Mantem a função escutando a fila por tempo indeterminado, até que seja encerrada
 */
while(count($channel->callbacks)) {
    $channel->wait();
}

$channel->close();
$connection->close();