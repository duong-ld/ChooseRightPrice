<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="./assets/css/answer.css">
    <title>Answer</title>

</head>

<header>
    <?php include('user_navbar.php'); ?>
</header>

<body>
    <div id="successModal" class="modal hide fade" data-backdrop="static" data-focus="false" role="dialog">
        <div class="modal-dialog">
            <div class="card">
                <div class="card-body text-center">
                    <iframe src="https://giphy.com/embed/fxsqOYnIMEefC" width="480" height="217" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
                    <br></br>
                    <h3>CONGRATULATIONS</h3>
                    <p>Right answer</p>
                </div>
                <div class="modal-content">
                    <a class="btn continue" href="game1.php">CONTINUE</a>
                </div>
            </div>
        </div>
    </div>

    <div id="failModal" class="modal hide fade" data-backdrop="static" data-focus="false" role="dialog">
        <div class="modal-dialog">
            <div class="card">
                <div class="card-body text-center">
                    <iframe src="https://giphy.com/embed/snBIjGhhAVrckywOzg" width="480" height="270" frameBorder="0" class="giphy-embed" allowFullScreen></iframe>
                    <br></br>
                    <h3>FAILED</h3>
                    <p>Ban qua den</p>
                </div>
                <div class="modal-content">
                    <a class="btn continue" href="game1.php">CONTINUE</a>
                </div>
            </div>
        </div>
    </div>

    <?php if (isset($_POST['success']))  { ?>
        <script>
            $('#successModal').modal('toggle')
        </script>
    <?php } if(1) { ?>
        <script>
            $('#failModal').modal('toggle')
        </script>
    <?php } ?>
</body>

</html>