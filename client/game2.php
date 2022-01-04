<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Game 2</title>
</head>

<body class="bg-white">
    <header>
        <?php include('user_navbar.php') ?>
    </header>

    <div class="container d-flex justify-content-center">
        <div class="card w-50 border-0 shadow rounded-3 my-5">
            <div class=" card-body">
                <h3>Welcome to the 2nd game</h3>
                <hr>
                <p style="font-size: large;">Fill in the letters X on the board to get a row of X</p>
                <hr>
                <p style="font-size: large;">Number of letters X: <?php echo (round($_SESSION['no_correct'] / 3)) ?></p>
                <div class="d-flex justify-content-center">
                    <a href="x_game.php" class="btn btn-primary">Start</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>