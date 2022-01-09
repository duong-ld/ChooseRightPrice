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
// send request, token to server
$token = $_SESSION['token'];
$user_id = $_SESSION['user-id'];
$msg = "7|" . $token . "|" . $user_id;

$ret = socket_write($socket, $msg, strlen($msg));
if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

$response = socket_read($socket, 1024);
if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

$response = explode("|", $response);

if ($response[0] == 0) {
    unset($_SESSION['token']);
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <title>Top Rank</title>
</head>

<body>
    <header>
        <?php include('user_navbar.php') ?>
    </header>
    <div class="container p-5 mt-5">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h3 class="text-center">Top Rank</h3>
                    </div>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Rank</th>
                            <th scope="col">Name</th>
                            <th scope="col">Money</th>
                        </tr>
                        <?php
                        for ($i = 0; $i < $response[1] * 2; $i = $i + 2) {
                            echo "<tr>";
                            echo "<td>" . ($i / 2 + 1) . "</td>";
                            echo "<td>" . $response[2 + $i] . "</td>";
                            echo "<td>" . $response[2 + $i + 1] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </thead>
                </table>
            </div>
        </div>
        <hr>
        <div>
            <?php
            $temp = socket_read($socket, 1024);
            if (!$temp) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");
            socket_close($socket);
            $temp = explode("|", $temp);
            if ($temp[0] == 0) {
                echo "<script>alert('You are not logged in!');</script>";
                echo "<script>window.location.href = 'login.php';</script>";
            }
            ?>

            <h3>Your Rank:</h3>
            <table class="table">
                <tr>
                    <td>Name</td>
                    <td><?php echo $temp[1] ?></td>
                </tr>
                <tr>
                    <td>Money</td>
                    <td><?php echo $temp[2] ?></td>
                </tr>
                <tr>
                    <td>Higher Rank</td>
                    <td><?php echo $temp[3] ?></td>
                </tr>
                <tr>
                    <td>Lower Rank</td>
                    <td><?php echo $temp[4] ?></td>
                </tr>
                <tr>
                    <td>Equal Rank</td>
                    <td><?php echo $temp[5] ?></td>
                </tr>
            </table>
        </div>
    </div>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</body>

</html>