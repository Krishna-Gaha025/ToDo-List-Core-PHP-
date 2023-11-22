<?php
    include '_dbconnect.php';
    // $note_id = $_GET['noteid'];
    $noteid = $_POST['snoEdit'];
    $titleEdit = $_POST['titleEdit'];
    $descEdit = $_POST['descriptionEdit'];

    $sql = "UPDATE notes SET note_title = '$titleEdit', note_desc = '$descEdit' WHERE note_id = $noteid";
    
    $result = mysqli_query($conn, $sql);
    
    header("Location: /eNotes/viewnotes.php?noteid=$noteid");

    mysqli_close($conn);
?>