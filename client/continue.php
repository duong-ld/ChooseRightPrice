<?php
session_start();

if (!$_SESSION['token']) {
    echo "<script>alert('You are not logged in!');</script>";
    echo "<script>window.location.href = 'login.php';</script>";
}
if (!$_SESSION['no_question']) {
    $_SESSION['no_question'] = 1;
    $_SESSION['no_correct'] = 0;
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
    <title>Question</title>
</head>

<body class="bg-white">
    <header>
        <?php include('user_navbar.php') ?>
    </header>

    <div class="container d-flex justify-content-center">
        <div class="card w-50 border-0 shadow rounded-3 my-5">
            <div class=" card-body">
                <h3>Chào mừng bạn đến với game đầu tiên</h3>
                <hr>
                <p style="font-size: large;">Bạn cần trả lời 9 câu hỏi lớn hơn hay nhỏ hơn. Cố gắng trả lời càng nhiều các tốt nhé!</p>
                <hr>
                <p>Bạn đang ở câu thứ <?php echo $_SESSION['no_question'] ?></p>
                <p>Bạn đã trả lời đúng <?php echo $_SESSION['no_correct'] ?> câu</p>
                <div class="d-flex justify-content-center">
                    <a href="question.php" class="btn btn-primary">Tiếp tục</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>