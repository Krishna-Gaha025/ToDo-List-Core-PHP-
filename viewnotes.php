<?php
    $insert = false;
    $update = false;
    $delete = false;
    include 'partials/_dbconnect.php';
    session_start();
    $loggedinuserid = $_SESSION['userid'];

    $noteid = $_GET['noteid'];

    // Delete Records
    if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `notes`.`note_id` = $sno";
    $result = mysqli_query($conn, $sql);
    if($result){
        header("Location: /eNotes/categories.php");
    }
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(isset($_POST['snoEdit'])){
            //Update the record
            $sno = $_POST['snoEdit'];
            $title = $_POST['titleEdit'];
            $description = $_POST['descriptionEdit'];

            $sql = "UPDATE `notes` SET `note_title` = '$title', `note_desc` = '$description' WHERE `notes`.`note_id` = $sno";
            $result = mysqli_query($conn, $sql);

            if($result){
                $update = true;
            }
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
    <link rel="stylesheet" href="partials/_viewnote.css">

    <title>View Note</title>
</head>

<body>
    <!-- ********************* HEADER ******************* -->
    <?php
       include 'partials/_navbar.php';
   ?>



    <!-- *************** INSERT NOTE Modal ************ -->
    <?php
    $sql = "SELECT * FROM `notes` where note_id = $noteid";
    $result = mysqli_query($conn, $sql);
    while($rows=mysqli_fetch_assoc($result)){
        $id = $rows['note_id'];
        $edittitle = $rows['note_title'];
        $editdesc = $rows['note_desc'];
    }
?>
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDIT NOTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    <form action="<?php echo 'partials/_update.php?noteid='.$noteid; ?>" method="post">
                        <div class="modal-body">
                            <div class="mb-3">
                                <input type="hidden" name="snoEdit" value="<?php echo $noteid; ?>" id="snoEdit">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="titleEdit" id="titleEdit"
                                    aria-describedby="emailHelp" value="<?php echo $edittitle; ?>">
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <div class="form-floating">
                                    <textarea class="form-control" name="descriptionEdit" id="descriptionEdit"
                                        style="height: 100px"><?php echo $editdesc; ?></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer d-block mr-auto">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>



    <!-- **********************Header Image******************* -->
    <?php
       $sql = "SELECT * FROM `notes` where note_id = $noteid";
       $result = mysqli_query($conn, $sql);
       $rows = mysqli_fetch_assoc($result);
       $note_title = $rows['note_title'];
       $note_desc = $rows['note_desc'];
   ?>

    <div class="headerImage">
        <p class="headingname"><?php echo $note_title ?></p>
    </div>

    <div class="container">
        <hr>
        <div id="cat_heading">
            <div id="div1">
                <p>
                    <button type="button" class="edit btn btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal" id="<?php echo $rows['note_id']; ?>">Edit</button>
                    <button type="button" class="delete btn btn-primary"
                        id="d<?php echo $rows['note_id']; ?>">Delete</button>
                </p>
            </div>
        </div>
        <hr>

        <div class="notedesc my-3">
            <p><?php echo $note_desc; ?></p>
        </div>
    </div>




    <script>
    // Delete the Notes
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1, );
            if (confirm("Do you want to delete note ?")) {
                window.location = `/eNotes/viewnotes.php?delete=${sno}`;
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