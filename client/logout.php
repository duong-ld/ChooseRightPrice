<?php
include('constant.php');
session_start();
if (!$_SESSION['token'] || !$_SESSION['user-id']) {
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

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
// send request, token to server
$token = $_SESSION['token'];
$user_id = $_SESSION['user-id'];
$msg = LOGOUT . "|" . $token . "|" . $user_id;

$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

// receive response from server
$response = socket_read($socket, 1024);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

$response = explode("|", $response);

if ($response[0] == 0) {
    unset($_SESSION['token']);
    unset($_SESSION['user-id']);
    echo "<script>alert('" . $response[1] . "');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

if ($response[1] == "S") {
    unset($_SESSION['token']);
    unset($_SESSION['user-id']);
    echo "<script>alert('Logout Success');</script>";
    echo "<script>window.location.href='login.php';</script>";
} else {
    echo "<script>alert('" . $response[2] . "');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}
