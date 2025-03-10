<?php

declare(strict_types=1);

namespace App\Infrastructure\Services;

class SocketClient
{
    public function runSocket(string|null $message): string|null
    {
        $socket = socket_create(AF_INET, SOCK_STREAM, 0);

        if (!$socket) {
            throw new \Exception("Erreur de création de socket : " . socket_strerror(socket_last_error()));
        }

        if (@socket_connect($socket, $_ENV['SOCKET_ADDRESS'], $_ENV['SOCKET_PORT'])) {
            socket_write($socket, $message, strlen($message));

            $recvMess = socket_read($socket, 1024);
            socket_close($socket);

            return $recvMess;
        }

        throw new \Exception("Échec de la connexion au serveur via le socket.");
    }
}
