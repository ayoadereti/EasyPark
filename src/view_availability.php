<?php
    session_start();
    $start_time = $_POST["start_time"];
    $end_time = $_POST["end_time"];
    $lot = $_POST["lot_location"];

    $conn = new mysqli("localhost", "root", "password", "EasyPark");

    if($conn->connect_error){
        die('Connection Failed : ' .$conn->connect_error);
    }
    else {
        $stmt = $conn->prepare("SELECT * FROM PERMIT WHERE Utd_id = ?");
        $stmt->bind_param("s", $_SESSION["username"]);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row= $result->fetch_assoc()) {
    
            $permit_num = $row["Permit_num"];
            echo $permit_num.": <br>";

                $stmt2 = $conn->prepare("SELECT Lot_name, Spot_num 
                                         FROM PARKING_SPOT, ACCESSES 
                                         WHERE ACCESSES.Permit_num = ?
                                         AND ACCESSES.Spot_color = PARKING_SPOT.Spot_color 
                                         AND Lot_name = ?
                                         AND Spot_num NOT IN (
                                            SELECT Spot_num
                                            FROM RESERVES
                                            WHERE Rstart = ? AND Rend = ? AND Lot_name = ?
                                        )
                                       
                                        AND Spot_num NOT IN (
                                            SELECT Spot_num
                                            FROM RESERVES 
                                            WHERE (RESERVES.Rstart < ? AND RESERVES.Rend > ?)
                                            OR
                                            (RESERVES.Rstart > ? AND RESERVES.Rstart < ?)
                                        )");
                // $stmt2->bind_param("sssss", $permit_num, $lot, $start_time, $end_time, $lot);
                $stmt2->bind_param("sssssssss", $permit_num, $lot, $start_time, $end_time, $lot, $start_time, $start_time, $start_time, $end_time);
                $stmt2->execute();

                $result2 = $stmt2->get_result();

                if ($result2->num_rows > 0) {
                    while($row= $result2->fetch_assoc()) {
                        // echo '<input type="radio" name="parking_spot" value="' . htmlspecialchars($row["Lot_name"] . ':' . $row["Spot_num"]) . '">';
                        // echo htmlspecialchars($row["Lot_name"] . ': ' . $row["Spot_num"]) . '<br>';
                        printf("%s: %s<br>", $row["Lot_name"], $row["Spot_num"]);
                    }
                    printf("<br>");
                }
                else {
                    echo "No spots available.\n<br>";
                }
        }
    }
        else {
            echo "No permit found. Add a permit to make reservations";
        }

    }