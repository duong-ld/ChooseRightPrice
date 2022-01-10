<?php
include('constant.php');
session_start();

if (!$_SESSION['token']) {
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

require('socket_config.php');

// send request, token to server
$token = intval($_SESSION['token']);
$user_id = intval($_SESSION['user-id']);
$msg = CONTINUER . "|" . $token . "|" . $user_id;

$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

$response = socket_read($socket, 1024);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

$response = explode("|", $response);

if ($response[0] == 0) {
    unset($_SESSION['token']);
    unset($_SESSION['user-id']);
    // not auth
    echo "<script>alert('" . strval($response[1]) . "');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

if ((0 <= $response[1] && $response[1] <= 11)
    && (0 <= $response[2] && $response[2] <= 9)
) {
    $_SESSION['no_question'] = intval($response[1]);
    $_SESSION['no_correct'] = intval($response[2]);
} else {
    echo "<script>alert('Wrong user data');</script>";
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
    <title>Continue</title>
</head>

<body class="bg-white">
    <header>
        <?php include('navbar.php') ?>
    </header>

    <?php if ($_SESSION['no_question'] <= 9) { ?>
        <div class="container d-flex justify-content-center">
            <div class="card w-50 border-0 shadow rounded-3 my-5">
                <div class=" card-body">
                    <h3>Welcome to the first game</h3>
                    <hr>
                    <p style="font-size: large;">You need to answer 9 bigger or smaller questions. Try to answer as many as possible!!</p>
                    <hr>
                    <p>You are at the question <?php echo $_SESSION['no_question'] ?></p>
                    <p>You answered <?php echo $_SESSION['no_correct'] ?> out of 9 questions correctly</p>
                    <div class="d-flex justify-content-center">
                        <a href="question.php" class="btn btn-primary">Continue</a>
                    </div>
                </div>
            </div>
        </div>
    <?php } else if ($_SESSION['no_question'] == 10) { ?>
        <script>
            alert(<?php echo $_SESSION['no_question'] ?>);
            window.location.href = "game2.php";
        </script>
    <?php } else { ?>
        <script>
            window.location.href = "game3.php";
        </script>
    <?php } ?>

</body>

</html>