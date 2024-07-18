<?php
    
error_reporting(E_ALL);
ini_set('display_errors', 1);

    session_start();
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $lot = $_POST["lot_location"];
    $spot = $_POST["spot_num"];

    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else {
        $stmt = $conn->prepare("SELECT Permit_num FROM PERMIT WHERE Utd_id = ?");
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $values = array();

            while ($row = $result->fetch_assoc()) {
                $values[] = $row["Permit_num"];
            }

            $row = $result->fetch_assoc();
        
            $stmt2 = $conn->prepare("SELECT Lot_name, Spot_num
                                    FROM PARKING_SPOT, ACCESSES
                                    WHERE PARKING_SPOT.Spot_color = ACCESSES.Spot_color
                                    AND ACCESSES.Permit_num in (?, ?)
                                    AND Lot_name = ?
                                    AND Spot_num = ?");
        $stmt2->bind_param("ssss", $values[0], $values[1], $lot, $spot);
        $stmt2->execute();
        $result2 = $stmt2->get_result();
        if ($result2->num_rows > 0) {
            $stmt3 = $conn->prepare("INSERT INTO RESERVES(RStart, Rend, Utd_id, Lot_name, Spot_num)
                                VALUES (?, ?, ?, ?, ?)");
            $stmt3->bind_param("sssss", $start_time, $end_time, $_SESSION["username"], $lot, $spot);
            $stmt3->execute();

            if($stmt3->affected_rows > 0) {
                echo "Reservation created";
            }
            else {
                echo "No spots available.\n<br>";
            }
        }
        else {
            echo "Cannot reserve selected spot. Choose a spot that corresponds to your permit";
        }

        }
        else{
            echo "No permit found. Add a permit to make reservations";
        }
    }