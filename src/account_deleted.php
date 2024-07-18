<?php
    session_start();
    $utd_id = $_SESSION["username"];

    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("DELETE FROM USER WHERE Utd_id = ?");

        $stmt->bind_param("s", $utd_id);
        $stmt->execute();

        header("Location: account_deleted.html");
        exit();
    }