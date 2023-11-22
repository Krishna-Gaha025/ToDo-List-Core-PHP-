<?php
    $server = "localhost";
    $username = "root";
    $password = "";
    $database = "e-notes";

    $conn = mysqli_connect($server, $username, $password, $database);
    if(!$conn){
        die("Unable to connect database: ". mysqli_connect_error());
    }
?>