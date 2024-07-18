<?php
    session_start();
    $lname = $_POST['lname'];
    $utd_id = $_SESSION["username"];

    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("UPDATE USER
                                SET Lname = ?
                                WHERE Utd_id = ?");

        $stmt->bind_param("ss", $lname, $utd_id);
        $stmt->execute();

        header("Location: modify_account.php");
        exit();
    }