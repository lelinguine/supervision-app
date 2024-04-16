<?php

function runSocket($message)
{
    $file = parse_ini_file("../src/Config/Setting.ini");
    //create socket
    $socket = socket_create(AF_INET, SOCK_STREAM, 0);
    //connect to server
    if(@socket_connect($socket, $file['address'], $file['port']))
    {
        //send mess
        socket_write($socket, $message, strlen($message));
        //receive mess
        $recvMess = socket_read($socket, 1024);
        //close com
        socket_close($socket);
        return $recvMess;
    }
}