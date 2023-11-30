<?php
session_start();

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

if (isset($_POST["login"])) {
    if (empty($_POST["user_name"]) || empty($_POST["password"])) {
        $message = '<label>Both fields need to be filled!</label>';
    } else {
        $password = $_POST["password"];

        // Prevent SQL Injection using prepared statements
        $query = "SELECT * FROM User WHERE user_name = 'admin' AND password = ?";
        $statement = $conn->prepare($query);
        $statement->bind_param("s", $password);
        $statement->execute();
        $result = $statement->get_result();

        if ($result->num_rows > 0) {
            $_SESSION["user_name"] = 'admin';
            header("location: input.php");
            exit();
        } else {
            $message = '<label>Password is incorrect!</label>';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login Page</title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>

<body>
    <div class="topnav" style="background-color: #5c2626; height: 10.6%; top: 0; left: 0;">
        <a href="imprintpage.html" style="padding-left: 200px;">Imprint Page</a>
    </div>
    <ul style="left: 0; top: 0;">
        <li><img src="img/Logo.png"></li>
        <li><a href="index.html">Home</a></li>
        <li><a href="awards.html">Awards</a></li>
        <li><a href="music.html">Music</a></li>
        <li><a href="artists.html">Artists</a></li>
		<li><a href="login.php">Maintanance Page</a></li>
    </ul>
    <h2 style="padding-left: 260px; padding-right: 200px; padding-top: 150px">
    Please log in as admin first: 
	</h2>
    <section style="padding-top: 20px; padding-left: 260px; padding-right: 20px">
    <?php
    if (isset($message)) {
        echo '<label>' . $message . '</label>';
    }
    ?>
    <form method="post">
        <label>User Name:</label><br><br>
        <input type="text" name="user_name" class="form-control" required/><br/><br/>
        <label>Password:</label><br><br>
        <input type="password" name="password" class="form-control" required/><br/><br>
        <input type="submit" name="login" class="btn btn-info" value="Login"/>
        
    </form>
    </section>
</body>

</html>

