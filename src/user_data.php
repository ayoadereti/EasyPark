<?php
    $utd_id = $_POST['utd_id'];
    $password = $_POST['password'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone_num = $_POST['phone_num'];

    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else{
        $stmt = $conn->prepare("INSERT INTO USER(Utd_id, Password, Fname, Lname, Email, Phone_num)
            values(?, ?, ?, ?, ?, ?)");

        $stmt->bind_param("sssssi", $utd_id, $password, $fname, $lname, $email, $phone_num);
        $stmt->execute();

        header("Location: registration_complete.html");
        exit();
    }