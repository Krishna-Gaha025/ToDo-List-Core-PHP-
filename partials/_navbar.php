<?php
    $loggedinuserid = $_SESSION['userid'];

    $sql = "SELECT * FROM `users` where user_id = $loggedinuserid";
    $result = mysqli_query($conn, $sql);
    $rows = mysqli_fetch_assoc($result);
    $username = $rows['username'];
    $userimage = $rows['user_image'];
?>

<div class="header">
    <div class="left">
        <img src="img/logo.png">
        <div class="logoname">E-Notes</div>
    </div>
    <div class="mid">
        <div class="navbar">
            <ul>
                <li><a href="categories.php">Home</a></li>
                <li><a href="feedback.php">Feedback</a></li>
                <li><a href="#">Contact</a></li>
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