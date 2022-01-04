<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Home Page</title>
</head>

<body>

    <header>
        <?php include('user_navbar.php'); ?>
    </header>

    <h2 class="text-center m-5">Welcome to the price is right</h2>

    <div class="container p-5">
        <div class="col-lg-10 col-offset-2 mx-auto">
            <div class="card shadow rounded-3">
                <div class="card-body p-4 p-sm-5">
                    <a href="new.php" class="btn btn-primary btn-lg btn-block">Start</a>
                    <a href="continue.php" class="btn btn-primary btn-lg btn-block">Continue</a>
                    <a href="rank.php" class="btn btn-primary btn-lg btn-block">Rank</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>