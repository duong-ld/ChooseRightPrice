<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="./assets/css/question.css">
    <title>Question</title>
</head>

<body>
    <header>
        <?php include('user_navbar.php'); ?>
    </header>

    <div class="container mt-sm-5 my-1">
        <form action="answer.php" method="post">
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
                <div class="ml-auto"> <button class="btn btn-success">Submit</button> </div>
            </div>
        </form>

    </div>

</body>

</html>