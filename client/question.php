<?php
session_start();
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

if (!$_SESSION['token'] || !$_SESSION['no_question']) {
    // not logged in, redirect to login page
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

$token = intval($_SESSION['token']);
$no_question = intval($_SESSION['no_question']);

// send request to server
$msg = "5|" . $token . "|" . $no_question;


$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

// receive response from server
$response = socket_read($socket, 1024);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

// split response from server
$response = explode("|", $response);

if ($response[0] == 0) {
    unset($_SESSION['token']);
    echo "<script>alert('You are not logged in!');</script>";
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
    <title>Question</title>
</head>

<body class="bg-white">
    <header>
        <?php include('user_navbar.php') ?>
    </header>

    <div class="container">
        <div class="card border-0 shadow rounded-3 my-5" style="align-content: center;">
            <div class=" card-body">
                <form action="answer.php" method="post">
                    <div class="py-2 h5 p-3"><b><?php echo $response[1] ?></b></div>
                    <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
                        <label class="options">
                            <?php echo $response[2] ?>$
                            <input type="radio" name="answer" value=<?php echo $response[2] ?>>
                            <span class="checkmark"></span>
                        </label>
                        <label class="options">
                            <?php echo $response[3] ?>$
                            <input type="radio" name="answer" value=<?php echo $response[3] ?>>
                            <span class="checkmark"></span>
                        </label>
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


</body>

</html>