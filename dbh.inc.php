<?php
    session_start();
    
    $dbServername = "localhost";
    $dbUsername = "root";
    $dbPassword = "123456";
    $dbName = "project";

    $conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);
    if (mysqli_connect_errno($conn)) {
        echo "Error connection: " . mysqli_connect_error();
        exit();
    }
?>
