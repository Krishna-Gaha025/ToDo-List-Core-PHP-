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
    <link rel="stylesheet" href="partials/_categories.css">

    <title>Categories</title>
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
                    <li><a href="#" class="active">Home</a></li>
                    <li><a href="feedback.php">Feedback</a></li>
                    <li><a href="contactus.php">Contact</a></li>
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

    <!-- **********************Header Image******************* -->
    <div class="headerImage">
        <p class="headingname">CATEGORIES</p>
    </div>



    <!-- **************** INSERT MODAL ****************** -->
    <div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">INSERT CATEGORY</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    <form action="/eNotes/categories.php" method="post">
                        <div class="mb-3">
                            <input type="hidden" name="cat_userid" value="<?php echo $loggedinuserid; ?>">
                            <label for="cat_title" class="form-label">Category Name</label>
                            <input type="text" class="form-control" name="cat_title" id="cat_title"
                                aria-describedby="emailHelp" required>
                        </div>
                        <button type="submit" class="btn btn-success">Insert</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <!-- **********************Categories********************* -->
    <!-- ******Insert Category****** -->
    <?php
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
           $cat_title = $_POST['cat_title'];
           $userid = $_POST['cat_userid'];

           $sql = "INSERT INTO `categories` (`cat_name`, `cat_user_id`, `cat_timestamp`) VALUES ('$cat_title', '$userid', current_timestamp())";
           $result = mysqli_query($conn, $sql);
       }
   ?>
    <div class="container my-3">
        <hr>
        <div id="cat_heading">
            <div id="div1">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    + Insert
                </button>
                <a type="button" class="btn btn-success" href="all.php">
                    View All
                </a>
            </div>
        </div>
        <hr>
        <div class="row">

            <!-- ************Display Category********** -->
            <?php
           $sql = "SELECT * FROM `categories` where cat_user_id = $loggedinuserid";
           $result = mysqli_query($conn, $sql);
           $nodata = true;
           while($rows=mysqli_fetch_assoc($result)){
               $nodata = false;
               $title = $rows['cat_name'];
               $cat_id = $rows['cat_id'];
               echo '<div class="col-md-3 my-2">
               <div class="card" style="width: 18rem;">
                    <div class="card-body">
                        <a href="notes.php?catid='.$cat_id.'">
                            <img src="img/cat_logo.png" id="catLogo">
                            <h5 class="card-title" id="cat_title">'.$title.'</h5>
                        </a>
                    </div>
                </div>
            </div>';
           }

           if($nodata){
                    echo '<div class="alert alert-success" role="alert">
                        <h4 class="alert-heading">NO CATEGORIES!</h4>
                        <p>Please press the insert button to add the category. Later on you can customize your categories name.</p>
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