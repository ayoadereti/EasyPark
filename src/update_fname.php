<?php
    session_start();
    $fname = $_POST['fname'];
    $utd_id = $_SESSION["username"];

    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("UPDATE USER
                                SET Fname = ?
                                WHERE Utd_id = ?");

        $stmt->bind_param("ss", $fname, $utd_id);
        $stmt->execute();

        header("Location: modify_account.php");
        exit();
    }