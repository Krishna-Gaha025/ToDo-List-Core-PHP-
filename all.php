<?php
    $insert = false;
    $update = false;
    $delete = false;
    include 'partials/_dbconnect.php';

    session_start();
    $loggedinuserid = $_SESSION['userid'];

    // Delete Records
    if(isset($_GET['delete'])){
    $sno = $_GET['delete'];
    $delete = true;
    $sql = "DELETE FROM `notes` WHERE `notes`.`note_id` = $sno";
    $result = mysqli_query($conn, $sql);
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
    <link rel="stylesheet" href="//cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>

    <script>
    $(document).ready(function() {
        $('#myTable').DataTable();
    });
    </script>

    <title>My-Notes</title>
</head>

<body>

    <!-- ********************* HEADER ********************* -->
    <?php
       include 'partials/_navbar.php';
   ?>


    <!-- **************Modal******************** -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">EDIT NOTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="modalbody">
                    <form action="/eNotes/all.php" method="post">
                        <div class="modal-body">
                            <input type="hidden" name="snoEdit" id="snoEdit">
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control" name="titleEdit" id="titleEdit"
                                    aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="desc" class="form-label">Description</label>
                                <div class="form-floating">
                                    <textarea class="form-control" name="descriptionEdit" id="descriptionEdit"
                                        style="height: 100px"></textarea>
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


    <?php
       if($insert){
           echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Your note has been added successfully.
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
       }
       if($update){
           echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Your note has been UPDATED!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
       }
       if($delete){
           echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Your note has been DELETED!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
       }
   ?>



    <div class="container my-3">
        <h3 class="text-center my-2">All Notes</h3>
        <table class="table" id="myTable">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Sno</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Handle</th>
                </tr>
            </thead>
            <tbody>
                <?php
           $sql = "SELECT * FROM `notes` where note_user_id = $loggedinuserid";
           $result = mysqli_query($conn, $sql);
           $sno = 0;
           while($rows=mysqli_fetch_assoc($result)){
               $sno = $sno + 1;
               $nTitle = $rows['note_title'];
               $nDesc = $rows['note_desc'];
                echo '<tr>
                        <th scope="row">'.$sno.'</th>
                        <td>'.$nTitle.'</td>
                        <td>'.$nDesc.'</td>
                        <td><button type="button" class="edit btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal" id="'.$rows["note_id"].'">Edit</button>
                        <button type="button" class="delete btn btn-primary" id="d'.$rows["note_id"].'">Delete</button>
                        </td>
                    </tr>';
           }
       ?>
            </tbody>
        </table>
    </div>

    <script>
    // Edits the Notes
    edits = document.getElementsByClassName('edit');
    Array.from(edits).forEach((element) => {
        element.addEventListener("click", (e) => {
            tr = e.target.parentNode.parentNode
            title = tr.getElementsByTagName("td")[0].innerText;
            description = tr.getElementsByTagName("td")[1].innerText;
            console.log(title, " || ", description);
            titleEdit.value = title;
            descriptionEdit.value = description;
            snoEdit.value = e.target.id;
            console.log(e.target.id);
            $('#editModal').modal('toggle'); //It will toggle the modal
        })
    })

    // Delete the Notes
    deletes = document.getElementsByClassName('delete');
    Array.from(deletes).forEach((element) => {
        element.addEventListener("click", (e) => {
            sno = e.target.id.substr(1, );
            if (confirm("Do you want to delete note ?")) {
                window.location = `/eNotes/all.php?delete=${sno}`;
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