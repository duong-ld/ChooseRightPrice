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

<header>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
        <a class="navbar-brand" href="#">
            <img src="./assets/image/background.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Hãy chọn giá đúng
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="true">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navb" class="navbar-collapse collapse hide">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="game1.php">Game 1</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Game 2</a>
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="#">Game 3</a>
                </li>
            </ul>

            <ul class="nav navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                </li>
            </ul>
        </div>
    </nav>
</header>

<body>

    <h2 class="text-center m-4">Chào mừng bạn đến với hãy chọn giá đúng</h2>

    <div class="col-sm-6 col-offset-2 mx-auto">
        <div class="card text-center m-3">
            <div class="card-body">
                <h3 class="card-title">Game 1</h3>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
            </div>
            <div class="card-footer text-muted">
                <a href="game1.php" class="btn btn-primary">Play</a>
            </div>
        </div>

        <div class="card text-center m-3">
            <div class="card-body">
                <h3 class="card-title">Game 1</h3>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

            </div>
            <div class="card-footer text-muted">
                <a href="#" class="btn btn-primary">Play</a>
            </div>
        </div>

        <div class="card text-center m-3">
            <div class="card-body">
                <h3 class="card-title">Game 1</h3>
                <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>

            </div>
            <div class="card-footer text-muted">
                <a href="#" class="btn btn-primary">Play</a>
            </div>
        </div>
    </div>

</body>

</html>