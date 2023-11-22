<?php
    include 'partials/_dbconnect.php';
    $showError = false;
    $showMsg = false;

    session_start();
    $loggedinuserid = $_SESSION['userid'];

    $sql = "SELECT * FROM `users` where user_id = $loggedinuserid";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_assoc($result);
    $username = $rows['username'];
    $email = $rows['email'];
    $address = $rows['address'];
    $doj = $rows['timestamp'];
    $userimage = $rows['user_image'];


    if(isset($_FILES['image'])){
        $myid = $_POST['userid'];
        $image_type = $_FILES['image']['type'];
        $image_name = $_FILES['image']['name'];
        $img_tmp = $_FILES['image']['tmp_name'];  
        $img_location = "img/userimage/".$image_name;

        if($userimage != 'defaultuser.png'){
            unlink("img/userimage/".$userimage);
        }

        $sql = "UPDATE users SET user_image = '$image_name' WHERE user_id = $loggedinuserid";
        
        $result = mysqli_query($conn, $sql);
        
        if(move_uploaded_file($img_tmp, $img_location)){
            $showMsg = true;
            $showMsg = "Image uploaded successfully!";
        }
        else{
            $showError = true;
            $showError = "Failed to upload Image!";
        }
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
    <link rel="stylesheet" href="partials/_userprofiles.css">

    <title>Profile-
        <?php echo strtok($username, " "); ?>
    </title>
</head>

<body>

    <!-- ********************* NAVIGATION BAR ******************* -->
    <?php include 'partials/_navbar.php'; ?>


    <!-- Image Upload Modal -->
    <div class="modal fade" id="uploadImage" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-dark" id="exampleModalLabel">UPLOAD IMAGE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    <form action="/enotes/userprofile.php" method="post" enctype="multipart/form-data">
                        <div class=" mb-3">
                            <input type="hidden" name="userid" value="<?php echo $loggedinuserid; ?>">
                            <input type="file" name="image" id="image" class="text-info">
                        </div>
                        <button type="submit" class="btn btn-success">Upload</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ******************************************* -->
    <div class="heading">Profile</div>
    <div class="container">
        <div class="cover"></div>
        <div class="userflex">
            <div class="image name">
                <img src="img/userimage/<?php echo $userimage; ?>" alt="No Image">
            </div>
            <div id="name" class="name"><?php echo $username; ?></div>
        </div>
        <p data-bs-toggle="modal" id="uploadimage" data-bs-target="#uploadImage">upload image</p>
    </div>




    <!-- ********** EDIT PROFILE MODAL ************* -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDIT PROFILE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    <form action="/enotes/partials/_edituserprofile.php" method="post">
                        <div class=" mb-3">
                            <label for="userprofile" class="form-label">Username</label>
                            <input type="text" class="form-control" name="editUsername" id="editUsername"
                                aria-describedby="emailHelp" value="<?php echo $username; ?>">
                        </div>
                        <div class=" mb-3">
                            <label for="userprofile" class="form-label">Address</label>
                            <input type="text" class="form-control" name="editAddress" id="editAddress"
                                aria-describedby="emailHelp" value="<?php echo $address; ?>">
                        </div>
                        <button type="submit" class="btn btn-success">Save Changes</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="containers my-3">
        <div class="content my-2">
            <p data-bs-toggle="modal" id="edit" data-bs-target="#editProfileModal">Edit Profile</p>
            <div class="mycontent">
                Email:<span class="editContent"> <?php echo $email; ?><span>
            </div>
            <div class="mycontent">
                Address:<span class="editContent"> <?php echo $address; ?><span>
            </div>
            <div class="mycontent">
                Date of Joining:<span class="editContent"> <?php echo $doj; ?><span>
            </div>
            <a href="partials/_logout.php" class="btn btn-success my-2">Logout</a>
        </div>
        <?php
            $sql = "SELECT * FROM `notes` where note_user_id = $loggedinuserid";
            $result = mysqli_query($conn, $sql);
            $numrows = mysqli_num_rows($result);
       ?>
        <p id="noteno">Total No. of Notes : <?php echo $numrows; ?></p>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>