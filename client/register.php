<?php
include('constant.php');
session_start();

// if already logged in, redirect to home page
if (isset($_SESSION['token'])) {
    echo "<script>window.location.href = 'home.php';</script>";
}

if (isset($_POST['signup'])) {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword'];
    $validate = 1;

    if (!preg_match("/^[A-Za-z ]+$/", $name)) {
        $name_error = "Name must contain only alphabets and space";
        $validate = 0;
    }
    if (!preg_match("/^[A-Za-z0-9]+$/", $username)) {
        $username_error = "Username is only character and number";
        $validate = 0;
    }
    if (strlen($password) < 5) {
        $password_error = "Password must be minimum of 5 characters";
        $validate = 0;
    }
    if ($password != $cpassword) {
        $cpassword_error = "Password and Confirm Password doesn't match";
        $validate = 0;
    }

    if ($username && $password && $validate) {

        require('socket_config.php');

        // send username, password to server
        $msg = REGISTER . "|" . $name . "|" . $username . "|" . $password;

        $ret = socket_write($socket, $msg, strlen($msg));
        if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

        // receive response from server
        $response = socket_read($socket, STRING_LENGTH);
        if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");

        // split response from server
        $response = explode("|", $response);

        if ($response[1] == "S") {
            // set session token
            $_SESSION['token'] = $response[2];
            $_SESSION['user-id'] = $response[3];
            // redirect to home page
            echo "<script>alert('Register success!');</script>";
            echo "<script>window.location.href = 'home.php';</script>";
        } else {
            echo "<script>alert('" . $response[2] . "');</script>";
            echo "<script>window.location.href = 'register.php';</script>";
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
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet">
    <title>Register</title>
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
                        <h2 class="card-title text-center mb-5 fw-light fs-5">Register</h2>
                        <form action="register.php" method="post">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="text" name="name" id="name" class="form-control" value="" maxlength="50" required="">
                                <span class="text-danger"><?php if (isset($name_error)) echo $name_error; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" id="username" class="form-control" value="" maxlength="20" required="">
                                <span class="text-danger"><?php if (isset($username_error)) echo $username_error; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" id="password" class="form-control" value="" maxlength="8" required="">
                                <span class="text-danger"><?php if (isset($password_error)) echo $password_error; ?></span>
                            </div>
                            <div class="form-group">
                                <label>Confirm Password</label>
                                <input type="password" name="cpassword" id="cpassword" class="form-control" value="" maxlength="8" required="">
                                <span class="text-danger"><?php if (isset($cpassword_error)) echo $cpassword_error; ?></span>
                            </div><br>
                            <input type="submit" class="btn btn-primary" name="signup" value="Register">
                            <br>
                            Already have a account? <a href="login.php" class="mt-3">Login</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>
</body>


</html>