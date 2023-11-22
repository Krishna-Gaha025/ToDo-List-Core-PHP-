<?php
    include 'partials/_dbconnect.php';

    session_start();
    if(!isset($_SESSION['loggedin']) && $_SESSION['loggedin']!=true){
        header("Location: /eNotes/");
    }
    $loggedinuserid = $_SESSION['userid'];

    $sql = "SELECT * FROM `users` where user_id = $loggedinuserid";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_assoc($result);
    $username = $rows['username'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <link rel="stylesheet" href="partials/_header.css">
    <link rel="stylesheet" href="partials/_contact.css">
    <title>Contact Form</title>
</head>

<body>

    <!-- ********************* HEADER ******************* -->
    <div class="header">
        <div class="left">
            <img src="img/logo.png">
            <div class="logoname">E-Notes</div>
        </div>
        <div class="mid">
            <div class="navbar">
                <ul>
                    <li><a href="categories.php">Home</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="contactus.php" class="active">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="right">
            <div class="username">
                <a href="userprofile.php">
                    <div class="name"><?php echo strtok($username, " "); ?></div>
                    <img src="img/defaultuser.png">
                </a>
            </div>
        </div>
    </div>


    <div class="container">
        <h3 class="text-center my-3">Contact us</h3>
        <form>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">UserName</label>
                <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Email address</label>
                <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
            </div>
            <div class="mb-3">
                <label for="contact reason">Contact Reason</label>
                <select id="contact reason" name="contact reason">
                    <option value="sales">maintainance</option>
                    <option value="help">security</option>
                    <option value="billing">other</option>
                </select>
            </div>
            <div class="mb-3">
                <div class="form-floating">
                    <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2"
                        style="height: 100px"></textarea>
                    <label for="floatingTextarea2">Description</label>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>