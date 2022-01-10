<?php
include('constant.php');
session_start();
// if already logged in, redirect to home page
if (isset($_SESSION['token'])) {
    echo "<script>window.location.href = 'home.php';</script>";
}

if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $validate = 1;

    if (!preg_match("/^[a-zA-Z0-9]+$/", $username)) {
        $username_error = "Username is only character and number";
        $validate = 0;
    }
    if (strlen($password) < 5) {
        $password_error = "Password must be minimum of 5 characters";
        $validate = 0;
    }

    if ($username && $password && $validate) {
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
        // send username, password to server
        $msg = LOGIN . "|" . $username . "|" . $password;

        $ret = socket_write($socket, $msg, strlen($msg));
        if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

        // receive response from server
        $response = socket_read($socket, 1024);
        if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

        // split response from server
        $response = explode("|", $response);

        if ($response[1] == "S") {
            $_SESSION['token'] = $response[2];
            $_SESSION['user-id'] = $response[3];
            echo "<script>alert('Login Success');</script>";
            echo "<script>window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('" . strval($response[2]) . "');</script>";
            echo "<script>window.location.href = 'login.php';</script>";
        }

        // close socket
        socket_close($socket);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Login</title>

</head>

<body>
    <header>
        <?php include('navbar.php'); ?>
    </header>


    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-offset-2 mx-auto">
                <div class="card border-0 shadow rounded-3 my-5">
                    <div class="card-body p-4 p-sm-5">
                        <h2 class="card-title text-center mb-5 fw-light fs-5">Login</h2>

                        <form action="login.php" method="post">
                            <div class="form-group ">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="" maxlength="20" required="">
                                <span class="text-danger"><?php if (isset($username_error)) echo $username_error; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control" value="" maxlength="8" required="">
                                <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                            </div><br>
                            <input type="submit" class="btn btn-primary" name="login" value="Login">
                            <br>
                            You don't have account? <a href="register.php" class="mt-3">Click Here</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>