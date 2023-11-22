<?php
    include 'partials/_dbconnect.php';
    session_start();
    $loggedinuserid = $_SESSION['userid'];

    $cat_id = $_GET['catid'];

    if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `categories` WHERE `categories`.`cat_id` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("Location: /eNotes/categories.php");
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
    <link rel="stylesheet" href="partials/_notes.css">

    <title>Notes</title>
</head>

<body>
    <!-- ********************* HEADER ******************* -->
    <?php
       include 'partials/_navbar.php';
   ?>

    <!-- **********************Slider******************* -->
    <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="img/1.png" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="img/2.png" class="d-block w-100">
            </div>
            <div class="carousel-item">
                <img src="img/3.png" class="d-block w-100">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>


    <!-- **********************Notes********************* -->
    <!-- ******Insert Notes****** -->
    <?php
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
           $note_title = $_POST['note_title'];
           $note_desc = $_POST['note_desc'];
           $id = $_POST['cat_id'];
           $userid = $_POST['noteuserid'];

           $sql = "INSERT INTO `notes` (`note_title`, `note_desc`, `note_user_id`, `category_id`, `note_timestamp`) VALUES ('$note_title', '$note_desc', '$userid', '$id', current_timestamp())";
           $result = mysqli_query($conn, $sql);
       }
   ?>



    <!-- *********** INSERT NOTE MODAL *********** -->
    <div class="modal fade" id="noteModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">INSERT NOTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post">
                        <?php echo '<input type="hidden" name="cat_id" value="'.$cat_id.'">'; ?>
                        <div class="mb-3">
                            <input type="hidden" name="noteuserid" value="<?php echo $loggedinuserid; ?>">
                            <label for="note_title" class="form-label">Title</label>
                            <input type="text" class="form-control" name="note_title" id="note_title"
                                aria-describedby="emailHelp" required>
                        </div>
                        <div class="mb-3">
                            <label for="note_desc" class="form-label">Description</label>
                            <div class="form-floating">
                                <textarea class="form-control" name="note_desc" id="note_desc"
                                    style="height: 100px"></textarea>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Insert</button>
                    </form>
                </div>
            </div>
        </div>
    </div>




    <!-- ********** UPDATE CATEGORY Modal *************** -->
    <?php
    $sql = "SELECT * FROM `categories` where cat_id = $cat_id";
    $result = mysqli_query($conn, $sql);
    while($rows=mysqli_fetch_assoc($result)){
        $catname = $rows['cat_name'];
    }
    ?>
    <div class="modal fade" id="updatecategoryModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">RENAME CATEGORY</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    <form action="<?php echo '/eNotes/partials/_catupdate.php?catid='.$cat_id; ?>" method="post">
                        <div class=" mb-3">
                            <label for="cat_title" class="form-label">Category Name</label>
                            <?php 
                            echo '<input type="hidden" name="catEdit" value="'.$cat_id.'" id="catEdit">';

                            echo '<input type="text" class="form-control" name="catname" id="catname"
                                aria-describedby="emailHelp" value="'.$catname.'">';
                            ?>
                        </div>
                        <button type="submit" class="btn btn-success">Update</button>
                </div>
                </form>
            </div>
        </div>
    </div>



    <!-- Displaying category name -->
    <?php
      $sql = "SELECT * FROM `categories` where cat_id = $cat_id";
      $result = mysqli_query($conn, $sql);
      $rows=mysqli_fetch_assoc($result);
      $cat_name = $rows['cat_name'];
  ?>
    <div class="container my-3">
        <hr>
        <div id="cat_heading">
            <div id="div1">
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#noteModal">
                    +Insert</button>
                <button type="button" class="btn btn-success" data-bs-toggle="modal"
                    data-bs-target="#updatecategoryModal">Rename</button>
                <button type="button" class="delete btn btn-primary"
                    id="d<?php echo $rows['cat_id']; ?>">Delete</button>
            </div>
            <div class="text-center" id="div2"><?php echo $cat_name ?></div>
        </div>
        <hr>
        <div class="row">

            <!-- ************Display Notes********** -->
            <?php
            $nodata = true;
           $sql = "SELECT * FROM `notes` where category_id=$cat_id AND note_user_id = $loggedinuserid";
           $result = mysqli_query($conn, $sql);
           while($rows=mysqli_fetch_assoc($result)){
               $nodata = false;
               $title = $rows['note_title'];
               $desc = $rows['note_desc'];
               $noteid = $rows['note_id'];
               echo '<div class="col-md-4 my-2">
                <div class="card" style="width: 18rem;">
                    <a href="viewnotes.php?noteid='.$noteid.'">
                        <div class="card-body">
                            <h4 class="card-title">'.$title.'</h4>
                            <p class="card-text">'.$desc.'</p>
                        </div>
                    </a>
                </div>
            </div>';
           }

           if($nodata){
                echo '<div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">NO NOTES!</h4>
                    <p>Please press the insert button to add the notes. Later on you can customize your notes.</p>
                </div>';
            }
       ?>

        </div>
    </div>

    <script>
    // Delete the Notes
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1, );
            if (confirm("Do you want to delete this category ?")) {
                window.location = `/eNotes/notes.php?delete=${sno}`;
            }
        })
    })
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
        integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
        integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
    </script>
</body>

</html>