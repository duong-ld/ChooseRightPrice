<?php
include('constant.php');
session_start();

if (!$_SESSION['token'] || !$_SESSION['user-id']) {
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}

if ($_SESSION['no_question'] != SPECIAL_QUESTION) {
    echo "<script>alert('Wrong user data!');</script>";
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
    <title>Game 3</title>
</head>

<body class="bg-white">
    <header>
        <?php include('navbar.php') ?>
    </header>

    <div class="container d-flex justify-content-center">
        <div class="card w-50 border-0 shadow rounded-3 my-5">
            <div class=" card-body">
                <h3>Welcome to the 3rd game</h3>
                <hr>
                <p style="font-size: large;">Answer question about product chains. Correct answer will get the full amount of the product chain</p>

                <div class="d-flex justify-content-center">
                    <a href="s_question.php" class="btn btn-primary">Start</a>
                </div>
            </div>
        </div>
    </div>

    <footer>
        <?php include('footer.php'); ?>
    </footer>

</body>

</html>