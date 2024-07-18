<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Main Menu</title>
</head>
<body>
    <div class="container" style="margin-top:100px; width:50%; text-align: center;">
    <button onclick="location.href='manager.html';" style="position: absolute; top: 50px; left: 210px;">Back</button>
        <h1>Account Details</h1>
        <p>Update account information</p>
        <?php
        session_start();
        $utd_id = $_SESSION["username"];

        $conn = new mysqli("localhost", "root", "password", "EasyPark");

        if($conn->connect_error) {
            die('Connection Failed : ' .$conn->connect_error);
        }
        else {
            $stmt = $conn->prepare("SELECT Password, Fname, Lname, Email, Phone_num
                                    FROM USER
                                    WHERE Utd_id =?");
    
            $stmt->bind_param("s", $utd_id);
            $stmt->execute();

            $stmt->bind_result($password, $fname, $lname, $email, $phone);  
            $stmt->fetch();

            $_SESSION["password"] = $password;
            $_SESSION["fname"] = $fname;
            $_SESSION["lname"] = $lname;
            $_SESSION["email"] = $email;
            $_SESSION["phone"] = $phone;
            printf("UTD ID: %s", $utd_id);
        }
        ?>
    
    <div class="container" style="margin-top:35px; width:50%; margin-left: 125px;">
        <p><?php
            session_start();
            printf("Password: %s", $_SESSION["password"]);
        ?></p>
        <form action="update_password.php" method="post"> 
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required><br><br></p>
            <input type="submit" value="Update">
        </form>
    </div>
    <div class="container" style="margin-top:35px; width:50%; margin-left: 125px;">
        <p><?php
            session_start();
            printf("First Name: %s", $_SESSION["fname"]);
        ?></p>
        <form action="update_fname.php" method="post"> 
            <label for="fname">First Name:</label>
            <input type="text" id="Fname" name="fname" required><br><br></p>
            <input type="submit" value="Update">
            </form>
    </div>
     <div class="container" style="margin-top:35px; width:50%; margin-left: 125px;">
        <p><?php
            session_start();
            printf("Last Name: %s", $_SESSION["lname"]);
        ?></p>
        <form action="update_lname.php" method="post"> 
            <label for="lname">Last Name:</label>
            <input type="text" id="Lname" name="lname" required><br><br></p>
            <input type="submit" value="Update">
         </form>
    </div>
    <p><?php
        session_start();
        printf("Email: %s", $_SESSION["email"]);
    ?></p>
     <div class="container" style="margin-top:50px; width:50%; margin-left: 125px;">
        <p><?php
            session_start();
            printf("Phone Number: %s", $_SESSION["phone"]);
        ?></p>
        <form action="update_phone.php" method="post"> 
            <label for="phone_num">Phone Number:</label>
            <input type="text" id="Phone_num" name="phone_num" required><br><br></p>
            <input type="submit" value="Update">
         </form>
    </div>
</body>
</html>
