<?php
    include '_dbconnect.php';
    $id = $_GET['catid'];
    $catid = $_POST['catEdit'];
    $catname = $_POST['catname'];

    $sql1 = "UPDATE categories SET cat_name = '$catname' WHERE cat_id = $catid";
    
    $result1 = mysqli_query($conn, $sql1);
    
    header("Location: /eNotes/notes.php?catid=$id");

    mysqli_close($conn);
?>