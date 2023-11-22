<?php
    include '_dbconnect.php';
    $showError = false;
    $showMsg = false;
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $email = $_POST['email'];
        $address = $_POST['address'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];

        $existsql = "SELECT * FROM `users` where email='$email'";
        $exitsresult = mysqli_query($conn, $existsql);
        $numRows = mysqli_num_rows($exitsresult);

        if($numRows > 0){
            $showError = true;
            $showError= "Email Already Exists!";
        }
        else{
            if($password == $cpassword){
                $hash = password_hash($password, PASSWORD_DEFAULT);
                $sql = "INSERT INTO `users` (`username`, `email`, `address`, `password`, `user_image`, `timestamp`) VALUES ('$username', '$email', '$address', '$hash', 'defaultuser.png', current_timestamp())";
    
                $result = mysqli_query($conn, $sql);
                if($result){
                    $showMsg = true;
                    $showMsg = "Your Account is successfully created!";
                    header("Location: /eNotes/index.php?signup=true&signupsuccess=$showMsg");
                    exit();
                }
            }
            else{
                $showError = true;
                $showError= "Password Donot Matched";
            }
        }
        header("Location: /eNotes/index.php?signup=false&signuperror=$showError");
    }
?>