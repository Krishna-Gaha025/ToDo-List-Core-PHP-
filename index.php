<?php
    include 'partials/_dbconnect.php';

    session_start();
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        header("Location: /eNotes/categories.php");
    }
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="partials/_main.css">

    <title>Signup</title>
</head>

<body>

    <!-- ***********************Navigation Bar****************** -->
    <nav class="navbar navbar-expand-lg d-flex">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <form action="/eNotes/partials/_handleLogin.php" method="post">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <p>E-Notes</p>
                        </li>
                        <li class="nav-item">
                            <input type="text" name="email" id="email" placeholder="Email" required>
                        </li>
                        <li class="nav-item">
                            <input type="password" name="password" id="password" placeholder="Password" required>
                        </li>
                        <li class="nav-item">
                            <input type="submit" value="Login" id="sub">
                        </li>
                </form>
                <li class="nav-item">

                </li>
                </ul>
            </div>
        </div>
    </nav>
    <hr>


    <!-- *********************SIGNUP FORM******************* -->
    <div class="containers">
        <div class="signup">
            <h3>Register Your Account</h3>
            <form action="/eNotes/partials/_handleSignup.php" method="post">
                <div class="mb-3">
                    <i class="fa fa-user icon"></i>
                    <input type="text" class="form-control" name="username" id="username" aria-describedby="emailHelp"
                        placeholder="Username" required>
                </div>
                <div class="mb-3">
                    <input type="email" class="form-control" name="email" id="email" aria-describedby="emailHelp"
                        placeholder="Email" required>
                </div>
                <div class="mb-3">
                    <input type="text" class="form-control" name="address" id="address" aria-describedby="emailHelp"
                        placeholder="Address" required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password"
                        required>
                </div>
                <div class="mb-3">
                    <input type="password" class="form-control" name="cpassword" id="cpassword"
                        placeholder="Confirm Password" required>
                </div>
                <button type="submit" class="btn btn-success">Register</button>
                <span class="mx-2">
                    <?php
                    if(isset($_GET['signup']) && $_GET['signup']=='true'){
                        echo $_GET['signupsuccess'];
                    }
                    if(isset($_GET['signup']) && $_GET['signup']=='false'){
                        echo $_GET['signuperror'];
                    }
                ?>
                </span>
            </form>
        </div>

        <div class="image">
            <img src="img/main.png">
            <p id="slogan">DIGITALIZED YOUR CONTENT</p>
            <a id="feedback" href="/eNotes/feedback.php">View Feedback</a>
            <a id="aboutus" href="/eNotes/aboutus.php">About-Us</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>