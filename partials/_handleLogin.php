<?php
    $showMsg = false;
    $showError = false;
    include '_dbconnect.php';
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM `users` where email='$email'";
        $result = mysqli_query($conn, $sql);
        $numRows = mysqli_num_rows($result);
        if($numRows==1){
            $rows = mysqli_fetch_assoc($result);
            if(password_verify($password, $rows['password'])){
                $showMsg = true;
                $showMsg = "Login Successfull";
                session_start();
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $rows['username'];
                $_SESSION['userid'] = $rows['user_id'];
                header("Location: /eNotes/categories.php?login=true&loginsuccess=$showMsg");
                exit();
            }
            else{
                $showError = true;
                $showError = "Invalid Credentials";
            }
        }
        else{
            $showError = true;
            $showError = "Invalid Credentials";
        }
        header("Location: /eNotes/index.php?login=false&loginfail=$showError");
    }
?>