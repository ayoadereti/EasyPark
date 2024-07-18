<?php
    session_start();

    $utd_id = $_SESSION["username"];
    $permit_num = $_POST['permit_num'];
    $permit_color = $_POST['permit_color'];

    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else{
        echo "yer";
        $stmt = $conn->prepare("INSERT INTO PERMIT(Permit_num, Utd_id, Permit_color)
            values(?, ?, ?)");

        $stmt->bind_param("sss", $permit_num, $utd_id, $permit_color);
        $stmt->execute();

        header("Location: permit_successful.html");
}
