<?php
include('constant.php');
session_start();
if (!$_SESSION['token'] || !$_SESSION['no_question'] || !$_SESSION['user-id']) {
    // not logged in, redirect to login page
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

if ($_SESSION['no_question'] != 11) {
    echo "<script>alert('Wrong user data!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

require('socket_config.php');

$token = intval($_SESSION['token']);
$user_id = intval($_SESSION['user-id']);
$no_question = intval($_SESSION['no_question']);

// send request to server
$msg = QUESTION . "|" . $token . "|" . $user_id . "|" . $no_question;

$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

// receive response from server
$response = socket_read($socket, STRING_LENGTH);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

// split response from server
$response = explode("|", $response);

if ($response[0] == ERROR) {
    unset($_SESSION['token']);
    unset($_SESSION['user-id']);
    echo "<script>alert('" . $response[1] . "');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

// close socket
socket_close($socket);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/question.css">
    <title>Special Question</title>
</head>

<body class="bg-white">
    <header>
        <?php include('navbar.php') ?>
    </header>

    <div class="container">
        <div class="card border-0 shadow rounded-3 my-5" style="align-content: center;">
            <div class=" card-body">
                <form action="answer.php" method="post">
                    <div class="py-2 h5 p-3">
                        <pre><?php echo $response[1] ?></pre>
                    </div>
                    <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3">
                        <input type="text" name="answer" class="form-control" placeholder="Answer">
                    </div>
                    <div class="d-flex align-items-center pt-3">
                        <div class="ml-auto">
                            <button class="btn btn-success">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>

</html>