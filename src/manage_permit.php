<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
</head>
<body>
    <div class="container" style="margin-top:100px; width:50%; text-align: center;">
        <button onclick="location.href='manager.html';">Back</button>
        <h1>Manage Permit(s)</h1>
        <?php
        session_start();
        $utd_id = $_SESSION["username"];

        $conn = new mysqli("localhost", "root", "password", "EasyPark");

        if($conn->connect_error) {
            die('Connection Failed : ' .$conn->connect_error);
        }
        else {
            $stmt = $conn->prepare("SELECT Permit_num, Permit_color 
                                    FROM PERMIT, USER
                                    WHERE USER.Utd_id = ?
                                    AND USER.Utd_id = PERMIT.Utd_id");
    
            $stmt->bind_param("s", $utd_id);
            $stmt->execute();

            $stmt->bind_result($pnum, $pcolor);
            $num = 1;

            while($stmt->fetch())    
            { 
               printf("Permit %d: \n<br>Permit Number: %s, Permit Color: %s\n<br>", $num, $pnum, $pcolor);
               $num++;
            } 
            echo "<br>";    
        }
        ?>
        <p>Add New Permit:</p>
        <form action="add_permit.php" method="post"> 
            <p><div class="form-group">
                <label for="permit_num">Permit Number:</label>
                <input type="text" id="permit_num" name="permit_num" required><br><br>
            </div></p>
            <p><div class="form-group">
                <label for="permit_color">Permit Color</label>
                <div>
                    <input type="radio" id="orange" name="permit_color" value="Orange"><label for="orange">Orange</label><br>
                    <input type="radio" id="evening orange" name="permit_color" value="Evening Orange"><label for="evening orange">Evening Orange</label><br>
                    <input type="radio" id="green" name="permit_color" value="Green"><label for="green">Green</label><br>
                    <input type="radio" id="gold" name="permit_color" value="Gold"><label for="gold">Gold</label><br>
                    <input type="radio" id="purple" name="permit_color" value="Purple"><label for="purple">Purple</label><br>
                    <input type="radio" id="accessible" name="permit_color" value="accessible"><label for="accessible">Accessible</label><br>
                </div>
            </div></p>
            <input type="submit" value="Add Permit">
        </form>
        </p><button onclick="location.href='';">Delete Existing Permit</button></p>
    </div>
</body>
</html>
