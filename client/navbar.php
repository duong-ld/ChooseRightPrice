<style>
    @import url('https://fonts.googleapis.com/css2?family=Montserrat&display=swap');
    .navbar {
        background-color: #8AAAE5;
        font-family: 'Montserrat', sans-serif;
    }
</style>

<nav class="navbar navbar-expand-md navbar-dark sticky-top">
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
                <a class="nav-link" href="home.php">Home</a>
            </li>
        </ul>

        <ul class="nav navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="register.php"><span class="fas fa-user"></span>Register</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php"><span class="fas fa-sign-in-alt"></span> Login</a>
            </li>
        </ul>
    </div>
</nav>