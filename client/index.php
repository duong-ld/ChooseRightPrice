<?php
session_start();

// if already logged in, redirect to home page
if (isset($_SESSION['token'])) {
    echo "<script>window.location.href = 'home.php';</script>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Home Page</title>

</head>



<body>
    <header>
        <?php include('navbar.php'); ?>
    </header>

    <div id="game" class="carousel slide" data-ride="carousel">
        <ul class="carousel-indicators">
            <li data-target="#game" data-slide-to="0" class="active"></li>
            <li data-target="#game" data-slide-to="1"></li>
        </ul>

        <!-- Wrapper for slides -->
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="./assets/image/chu_x_bi_an.jpeg" alt="Chu X bi an" width="1100" height="500">
                <div class="carousel-caption">
                </div>
            </div>
            <div class="carousel-item">
                <img src="./assets/image/ban_tay_vang.png" alt="Ban tay vang" width="1100" height="500">
                <div class="carousel-caption">
                </div>
            </div>
        </div>

        <a class="carousel-control-prev" href="#game" data-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </a>
        <a class="carousel-control-next" href="#game" data-slide="next">
            <span class="carousel-control-next-icon"></span>
        </a>
    </div>

</body>

</html>