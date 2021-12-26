<!DOCTYPE html>
<html lang="en">

<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    body,
    html {
        height: 100%;
        margin: 0;
        font-family: 'Montserrat', sans-serif;
    }

    body{
        background-image: url(./assets/image/background.png);
        background-repeat: no-repeat;
        background-position: 50% 11rem;
        /* background-size: cover; */
    }

    .bg-text {
        /* background-color: black; */
        /* Fallback color */
        /* background-color: rgba(0, 0, 0, 0.4); */
        /* Black w/opacity/see-through */
        color: green;
        font-weight: bold;
        font-size: 3.5rem;
        font-style: italic;
        /* border: 10px solid #f1f1f1; */
        /* position: fixed;
        top: 10%;
        left: 50%;
        transform: translate(-50%, -50%); */
        /* z-index: 2; */
        width: 100%;
        padding: 20px;
        text-align: center;
    }

</style>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <title>Home Page</title>
</head>

<body>
    <?php include('navbar.php'); ?>
    <div class="mx-auto">
        <!-- <h2 style="text-align: center; color:brown">Chao mung ban den voi game show hay chon gia dung</h2> -->
        <div class="bg-text">Chào mừng bạn đến với gameshow</div>
    </div>

</body>

</html>