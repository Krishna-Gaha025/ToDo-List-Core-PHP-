<?php
    include 'partials/_dbconnect.php';
    $showheader = false;
    $comment = false;
    session_start();
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']==true){
        $showheader = true;
        $comment = true;
        
        $loggedinuserid = $_SESSION['userid'];
        $sql = "SELECT * FROM `users` where user_id = $loggedinuserid";
        $result = mysqli_query($conn, $sql);
        $rows = mysqli_fetch_assoc($result);
        $username = $rows['username'];
    }
    else{
        $showheader = false;
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
    <link rel="stylesheet" href="partials/_header.css">

    <style>
    .content {
        border: 3px solid;
        min-height: 300px;
        background-image: url("img/classic1.png");
        background-repeat: no-repeat;
        background-size: cover;
    }

    .container {
        min-height: 600px;
    }
    </style>

    <title>Feedback</title>
</head>

<body>

    <!-- ******************* HEADER ********************** -->
    <?php
    if($showheader){
        echo '<div class="header">
        <div class="left">
            <img src="img/logo.png">
            <div class="logoname">E-Notes</div>
        </div>
        <div class="mid">
            <div class="navbar">
                <ul>
                    <li><a href="categories.php">Home</a></li>
                    <li><a href="feedback.php" class="active">Feedback</a></li>
                    <li><a href="contactus.php">Contact</a></li>
                </ul>
            </div>
        </div>
        <div class="right">
            <div class="username">
                <a href="userprofile.php">
                    <div class="name">'.strtok($username, " ").'</div>
    <img src="img/defaultuser.png">
    </a>
    </div>
    </div>
    </div>';
    }
    ?>


    <!-- ************************ Feedback Content ******************** -->
    <div class="container my-3">
        <?php
           if($_SERVER['REQUEST_METHOD']=='POST'){
                $comment = $_POST['comment'];
                $userid = $_POST['userid'];
                $comment = str_replace("<", "&lt;", $comment);
                $comment = str_replace(">", "&gt;", $comment);

                $sql = "INSERT INTO `feedback` (`feedback_content`, `feedback_user_id`, `feedback_time`) VALUES ('$comment', '$userid', current_timestamp())";
                $result = mysqli_query($conn, $sql);
           }
       ?>


        <!-- ***************Feedback****************** -->
        <h3 class="text-center my-3">FeedBack</h3>
        <?php
           if($comment){
               echo '<form action="/eNotes/feedback.php" method="post">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Comment Your Query</label>
                        <input type="hidden" name="userid" value="'.$loggedinuserid.'">
                        <input type="text" class="form-control" id="comment" name="comment" aria-describedby="emailHelp">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>';
    }
    else{
    echo '<div class="alert alert-primary d-flex align-items-center" role="alert">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor"
            class="bi bi-exclamation-triangle-fill flex-shrink-0 me-2" viewBox="0 0 16 16" role="img"
            aria-label="Warning:">
            <path
                d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
        </svg>
        <div>
            Please Login to comment your query
        </div>
    </div>';
    }
    ?>

        <div class="content my-3">
            <?php
        $sql = "SELECT * FROM `feedback`";
        $result = mysqli_query($conn, $sql);
        while($rows=mysqli_fetch_assoc($result)){
            $content = $rows['feedback_content'];
            $feedback_user_id = $rows['feedback_user_id'];

            $sql1 = "SELECT * FROM `users` where user_id = $feedback_user_id";
            $result1 = mysqli_query($conn, $sql1);
            $rows=mysqli_fetch_assoc($result1);
            $user_name = $rows['username'];

            echo '<div class="d-flex my-3">
                <div class="flex-shrink-0">
                    <img src="img/defaultuser.png" height="50">
                </div>
                <div class="flex-grow-1 ms-3 my-2">
                    <h6 class="my-0">'.$user_name.'</h6>
                    <div id="border">
                        <p class="my-0">'.$content.'</p>
                    </div>
                </div>
            </div>';
        }
        ?>
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