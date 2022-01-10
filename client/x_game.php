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

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/x_game.css">
    <title>X game</title>
</head>


<body>
    <header>
        <?php include('user_navbar.php'); ?>
    </header>
    <div class="title">
        <h1>Mysterious X</h1>
    </div>
    <br>
    <div class="container justify-content-center d-flex">
        <div id="game">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </div>

    <div id="btn" class="pt-5">
        <?php $numClickable = round($_SESSION['no_correct'] / 3) ?>
        <button class="btn btn-warning btn-lg mr-5" onclick="play(<?php echo $numClickable ?>)">Play</button>
        <button class="btn btn-success btn-lg" onclick="check()">Check</button>
    </div>

    <!-- Modal content -->
    <div id="successModal" class="modal fade" data-backdrop="static" data-focus="false" role="dialog">
        <div class="modal-dialog">
            <div class="card">
                <div class="card-body text-center">
                    <iframe src="https://giphy.com/embed/fxsqOYnIMEefC" width="480" height="217" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
                    <br></br>
                    <h3>CONGRATULATIONS</h3>
                    <p>You can go to the special game !!!</p>
                </div>
                <div class="modal-content">
                    <a class="btn continue" href="game3.php">CONTINUE</a>
                </div>
            </div>
        </div>
    </div>

    <div id="failModal" class="modal fade" data-backdrop="static" data-focus="false" role="dialog">
        <div class="modal-dialog">
            <div class="card">
                <div class="card-body text-center">
                    <iframe src="https://giphy.com/embed/snBIjGhhAVrckywOzg" width="480" height="270" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
                    <br></br>
                    <h3>FAILED</h3>
                    <p>Better luck next time !!!</p>
                </div>
                <div class="modal-content">
                    <a class="btn btn-primary" href="result.php">Result</a>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript" src="./assets/js/x_game.js"></script>
    <?php
    echo '<script type="text/javascript">
            play(' . round($_SESSION['no_correct'] / 3) . ');
         </script>';
    ?>

    <?php
    // send result to server
    // send pass minigame message to server
    $token = intval($_SESSION['token']);
    $user_id = intval($_SESSION['user-id']);
    $no_question = intval($_SESSION['no_question']);
    $answer = 1;
    $message = ANSWER . "|" . $token . "|" . $user_id . "|" . $no_question . "|" . $answer;
    socket_write($socket, $message, strlen($message));
    $_SESSION['no_question'] = intval($_SESSION['no_question']) + 1;
    ?>
</body>

</html>