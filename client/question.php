<?php
include('constant.php');
session_start();

if (!$_SESSION['token'] || !$_SESSION['no_question'] || !$_SESSION['user-id']) {
    // not logged in, redirect to login page
    echo "<script>alert('You are not logged in!');</script>";
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
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

// close socket
socket_close($socket);
?>

<script type="text/javascript">
    const end_time = <?php echo $_SESSION["start_time"] + ANSWER_TIME; ?>;
    var current_time = <?php echo time(); ?>;
</script>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/question.css">
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/gh/sygmaa/CircularCountDownJs@master/circular-countdown.min.js"></script>
    <title>Question</title>
</head>

<body class="bg-white">
    <header>
        <?php include('navbar.php') ?>
    </header>

    <div class="container d-flex flex-row-reverse">
        <div class="timer"></div>
    </div>

    <div class="container">
        <div class="card border-0 shadow rounded-3 my-5" style="align-content: center;">
            <div class=" card-body">
                <form id="question" action="answer.php" method="post">
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

    <script src="./assets/js/countdown.js"></script>
    <script type="text/javascript">
        var myInterval = setInterval("reloadFunc()", 4000);

        function reloadFunc() {
            if (!window.document.hasFocus()) {
                clearInterval(myInterval);
                if (confirm('Looks like you just left the game!! Your question could have been changed. Please reload to not affect the results') == true) {
                    window.location.reload();
                }
                else {
                    myInterval = setInterval("reloadFunc()", 4000);
                }
            }
        }
    </script>

</body>

</html>