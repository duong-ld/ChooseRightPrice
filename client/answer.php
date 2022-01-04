<?php
session_start();
if (isset($_POST['answer'])) {
    $answer = floatval($_POST['answer']);

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


    // send answer to server
    if ($_SESSION['token']) {
        $token = intval($_SESSION['token']);
        $no_question = intval($_SESSION['no_question']);
        $msg = "6|" . $token . "|" . $no_question . "|" . $answer;
    } else {
        $msg = "6|0|" . $no_question . "|" . $answer;
    }

    $ret = socket_write($socket, $msg, strlen($msg));
    if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

    // receive response from server
    $response = socket_read($socket, 1024);
    if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

    // split response from server
    $response = explode("|", $response);

    if ($response[0] == 0) {
        unset($_SESSION['token']);
        echo "<script>alert('" . strval($response[1]) . "');</script>";
        echo "<script>window.location.href = 'login.php';</script>";
    }
} else {
    echo "<script>alert('You are not answer!');</script>";
    echo "<script>window.location.href = 'question.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <?php
    $no_question = intval($_SESSION['no_question']) + 1;
    $_SESSION['no_question'] = $no_question;

    if ($response[1] == 'S') {
        // render correct answer
        echo "<div class='container p-5'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<div class='card border-0 shadow rounded-3 my-5' style='background-color: #88ff72;'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Correct Answer</h5>";
        echo "<p class='card-text'>";
        echo "Your answer is correct!";
        echo "</p>";
        $_SESSION['no_correct'] = intval($_SESSION['no_correct']) + 1;
    } else if ($response[1] == 'F') {
        // render wrong answer
        echo "<div class='container p-5'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<div class='card border-0 shadow rounded-3 my-5' style='background-color: #ff5858;'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Wrong Answer</h5>";
        echo "<p class='card-text'>";
        echo "Your answer is wrong!";
        echo "</p>";
    } else {
        // render timeout
        echo "<div class='container p-5'>";
        echo "<div class='row'>";
        echo "<div class='col-md-12'>";
        echo "<div class='card border-0 shadow rounded-3 my-5' style='background-color: #ff5858;'>";
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>Time Out</h5>";
        echo "<p class='card-text'>";
        echo "Your answer is timeout!";
        echo "</p>";
    }
    if ($_SESSION['no_question'] <= 9) {
        echo "<a href='question.php' class='btn btn-primary'>Next Question</a>";
    } else if ($_SESSION['no_question'] == 10) {
        if ($_SESSION['no_correct'] < 5) {
            echo "<script>alert('You are failed!');</script>";
            echo "<script>window.location.href = 'home.php';</script>";
            $_SESSION['no_correct'] = 0;
            $_SESSION['no_question'] = 1;
        }
        echo "<a href='game2.php' class='btn btn-primary'>X game</a>";
    } else {
        echo "<a href='result.php' class='btn btn-primary'>Result</a>";
    }
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    ?>

</body>

</html>