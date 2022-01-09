<?php
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

$token = intval($_SESSION['token']);
$user_id = intval($_SESSION['user-id']);
$no_question = intval($_SESSION['no_question']);

// send request to server
$msg = "5|" . $token . "|" . $user_id . "|" . $no_question;

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

if ($response[1] >= 0 && $response[1] <= 9) {
    $_SESSION['no_correct'] = $response[1];
} else {
    echo "<script>alert('Wrong user data!');</script>";
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
    <title>Game 2</title>
</head>

<body class="bg-white">
    <header>
        <?php include('user_navbar.php') ?>
    </header>

    <div class="container d-flex justify-content-center">
        <div class="card w-50 border-0 shadow rounded-3 my-5">
            <div class=" card-body">
                <h3>Welcome to the 2nd game</h3>
                <hr>
                <p style="font-size: large;">Players will receive the program's reward, if they can arrange the letters X in a horizontal or a diagonal row with the mysterious X of the program. If you answer 3 questions correctly in round 1, you will get 1 X.</p>
                <hr>
                <p style="font-size: large;">Number of letters X: <?php echo (round($_SESSION['no_correct'] / 3)) ?></p>
                <div class="d-flex justify-content-center">
                    <a href="x_game.php" class="btn btn-primary">Start</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>