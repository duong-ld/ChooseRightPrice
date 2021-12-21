<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php
    $name = $_POST['name'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($username && $password) {
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
        $msg = "2|" . $name . "|" . $username . "|" . $password;

        $ret = socket_write($socket, $msg, strlen($msg));
        if (!$ret) die("client write fail:" . socket_strerror(socket_last_error()) . "\n");

        // receive response from server
        $response = socket_read($socket, 1024);
        if (!$response) die("client read fail:" . socket_strerror(socket_last_error()) . "\n");
        echo $response;

        // split response from server
        $response = explode("|", $response);

        if ($response[1] == "S") {
            echo "<script>alert('Register success!');</script>";
            echo "<script>window.location.href = 'index.php';</script>";
        } else {
            // alert $reponse[2] to user
            echo "<script>alert('Register fail!');</script>";
            echo "<script>window.location.href = 'register.php';</script>";
        }

        // close socket
        socket_close($socket);
    }
    ?>
</head>

<body>
    <!-- register form -->
    <form action="register.php" method="post">
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name">
        </div>
        <div>
            <label for="username">Username:</label>
            <input type="text" name="username" id="username">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" name="password" id="password">
        </div>
        <div>
            <input type="submit" value="Register">
        </div>
    </form>
</body>

</html>