<?php
    // create socket
    $socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
    if ($socket === false) {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }
    // connect to server
    $result = socket_connect($socket, "127.0.0.1", 9999);
    if ($result === false) {
        echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
    }
?>