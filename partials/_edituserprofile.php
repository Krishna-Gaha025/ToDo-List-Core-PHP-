<?php
    include '_dbconnect.php';

    $editUsername = $_POST['editUsername'];
    $editAddess = $_POST['editAddress'];
    session_start();
    $loggedinuserid = $_SESSION['userid'];

    $sql1 = "UPDATE users SET username = '$editUsername', address = '$editAddess' WHERE user_id = $loggedinuserid";
    $result1 = mysqli_query($conn, $sql1);
    
    header("Location: /eNotes/userprofile.php");

    mysqli_close($conn);
?>