<!DOCTYPE html>
<html>
<?php
$servername = "localhost";
$username = "mborsos";
$password = "y0WmsG";
$dbname = "Group-11";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
<body>
    <center>
        <?php

            $name = $_REQUEST['user_name'];
            $password = $_REQUEST['password'];

            $stmt = $conn->prepare("INSERT INTO User (user_name, password) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $password);
            $stmt->execute();

            echo 'You have registered!';
            $stmt->close();
            $conn->close();
       
        ?>
    </center>
</body>
</html>
