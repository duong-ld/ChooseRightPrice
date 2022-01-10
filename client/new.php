<?php
include('constant.php');
session_start();

if (!$_SESSION['token'] || !$_SESSION['user-id']) {
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

require('socket_config.php');

// send message to reset question on server
$token = intval($_SESSION['token']);
$user_id = intval($_SESSION['user-id']);
$msg = RESET . "|" . $token . "|" . $user_id;
$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

// receive response from server
$response = socket_read($socket, 1024);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

// close socket
socket_close($socket);

$response = explode("|", $response);

if ($response[0] == '0') {
    unset($_SESSION['token']);
    unset($_SESSION['user-id']);
    echo "<script>alert('" . $response[1] . "');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

$_SESSION['no_question'] = 1;
$_SESSION['no_correct'] = 0;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Question</title>
</head>

<body class="bg-white">
    <header>
        <?php include('navbar.php') ?>
    </header>

    <div class="container d-flex justify-content-center">
        <div class="card w-50 border-0 shadow rounded-3 my-5">
            <div class=" card-body">
                <h3>Welcome to the first game</h3>
                <hr>
                <p style="font-size: large;">You need to answer 9 bigger or smaller questions. Try to answer as many as possible!!</p>
                <div class="d-flex justify-content-center">
                    <a href="question.php" class="btn btn-primary">Start</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>