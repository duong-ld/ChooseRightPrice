<?php
include('constant.php');
session_start();

if (!$_SESSION['token'] || !$_SESSION['user-id']) {
    echo "<script>alert('You are not login!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

require('socket_config.php');

$token = $_SESSION['token'];
$user_id = $_SESSION['user-id'];
$msg = RESULT . "|" . $token . "|" . $user_id;

$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

$response = socket_read($socket, 1024);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

$response = explode("|", $response);

if ($response[0] == 0) {
    unset($_SESSION['token']);
    unset($_SESSION['user-id']);
    echo "<script>alert('" . $response[1] . "');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Result</title>

</head>

<body>
    <header>
        <?php include('navbar.php') ?>
    </header>

    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h3>Result</h3>
            </div>
            <div class="card-body">
                <div class="col-md-8">
                    <h4>Game 1: <?php echo $response[1]; ?>/9</h4>
                    <h4>Game 2: <?php echo $response[2]; ?></h4>
                    <h4>Game 3: <?php echo $response[3]; ?>$</h4>
                    <hr>
                    <h4>Overall: + <?php echo $response[3]; ?>$</h4>
                </div>
                <div class="d-flex align-items-center pt-3">
                    <div class="ml-auto">
                        <a href="new.php" class="btn btn-primary">Play Again</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>