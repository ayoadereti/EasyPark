<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation View</title>
</head>
<body>
    <div class="container" style="margin-top:100px; width:50%; text-align: center;">
        <h1>Current Reservation(s)</h1>
        <?php
        session_start();
        $utd_id = $_SESSION["username"];
         
        $conn = new mysqli("localhost", "root", "password", "EasyPark");

        if($conn->connect_error) {
            die('Connection Failed : ' .$conn->connect_error);
        }
        else {
            $stmt = $conn->prepare("SELECT *
                                    FROM RESERVES
                                    WHERE Utd_id =?");
    
            $stmt->bind_param("s", $utd_id);
            $stmt->execute();

            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                $num = 1;
                while($row= $result->fetch_assoc()) {
                    echo "Reservation ".$num.": <br>";
                    echo "Start Time: ".$row["Rstart"]."<br>";
                    echo "End Time: ".$row["Rend"]."<br>";
                    echo "Location: ".$row["Lot_name"]." ".$row["Spot_num"]."<br>";
                    echo "<br>";
                    $num++;
                }
            }
            else {
                echo "No existing reservations";
            }
        }
        ?>
        <button onclick="location.href='create_reservation.html';">Create Reservation</button>
        <button onclick="location.href='';">Manage Reservations</button>
        <button onclick="location.href='main_menu.html';">Back</button>
    </div>
</body>
</html>