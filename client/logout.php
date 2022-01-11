<?php
include('constant.php');
session_start();
if (!$_SESSION['token'] || !$_SESSION['user-id']) {
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

require('socket_config.php');

// send request, token to server
$token = $_SESSION['token'];
$user_id = $_SESSION['user-id'];
$msg = LOGOUT . "|" . $token . "|" . $user_id;

$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

// receive response from server
$response = socket_read($socket, STRING_LENGTH);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

$response = explode("|", $response);

if ($response[0] == ERROR) {
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
