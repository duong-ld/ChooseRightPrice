<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/game.css">
    <title>Game 1</title>
</head>

<header>
    <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
        <a class="navbar-brand" href="home.php">
            <img src="./assets/image/background.png" width="30" height="30" class="d-inline-block align-top" alt="">
            Hãy chọn giá đúng
        </a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navb" aria-expanded="true">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div id="navb" class="navbar-collapse collapse hide">
            <ul class="navbar-nav">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Game 1</a>
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
    <div class="container mt-sm-5 my-1">
        <div class="question ml-sm-5 pl-sm-5 pt-2">
            <div class="py-2 h5"><b>What's your name</b></div>
            <div class="ml-md-3 ml-sm-3 pl-md-5 pt-sm-0 pt-3" id="options">
                <label class="options">Small Business Owner or Employee <input type="radio" name="radio"> <span class="checkmark"></span></label>
                <label class="options">Nonprofit Owner or Employee <input type="radio" name="radio"> <span class="checkmark"></span> </label>
                <label class="options">Journalist or Activist <input type="radio" name="radio"> <span class="checkmark"></span> </label>
                <label class="options">Other <input type="radio" name="radio"> <span class="checkmark"></span> </label>
            </div>
        </div>
        <div class="d-flex align-items-center pt-3">
            <div id="prev"> <button class="btn btn-primary">Previous</button> </div>
            <div class="ml-auto"> <button class="btn btn-success">Next</button> </div>
        </div>
    </div>

</body>

</html>