<?php

    // Start a session 
    session_start();

    // Login Parameters
    $username = $_POST["user"];
    $password = $_POST["pwd"];
    $_SESSION["username"] = $username;

    // Database Connection
    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    // Verify Connection
    if ($conn->connect_error) {
        die("Failed to Connect". $conn->connect_error);
    }
    else {
        // Prepare and bind 
        $stmt = $conn->prepare("SELECT Utd_id, Password FROM USER WHERE Utd_id = ? and Password = ?");
    
        $stmt->bind_param("ss", $username, $password);
        $stmt->execute();

        $stmt->bind_result($username, $password);
        if ($stmt->fetch()) {
            // User found, go to main menu
            header("Location: main_menu.html");
            exit();
        }
        else {
            // User not found, redirect back to login 
            header("Location: failed_login.html");
        }
    }
   

