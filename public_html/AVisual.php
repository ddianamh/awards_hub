<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
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

// Check if 'award_id' is set in the URL
if (isset($_GET['award_id'])) {
    $id = $_GET["award_id"];
    $sql = "SELECT winner_visual, visual_title, year, Visual_Award.award_id FROM Visual_Award LEFT JOIN Award ON Award.award_id = Visual_Award.award_id WHERE Visual_Award.award_id = '$id';";
    $result = $conn->query($sql);

    // Check for errors
    if ($conn->error) {
        die("Error executing query. Please try again later.");
    }
} else {
    // 'award_id' is not set, handle it accordingly (redirect, show an error, etc.)
    die("No 'award_id' provided in the URL.");
}

?>

<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <title>Awards</title>
    <style>
        table {
            margin: 0 auto;
            font-size: large;
            border: 1px solid transparent;
            background-color: #5c2626;
        }

        td {
            border: 1px solid transparent;
            margin: 10px;
            color: #d8c690;
            font-weight: lighter;
            padding: 10px;
            text-align: center;
        }

        th {
            font-weight: bold;
            border: 1px solid black;
            color: #cbb26a;
            padding: 10px;
            text-align: center;
            margin: 10px;
        }
    </style>
</head>
<body>
    <div class="topnav" style="background-color: #5c2626; height: 12%;">    
        <a href="imprintpage.html" style="margin-left: 70px;">Awards from the year you selected:</a>
    </div>
    <ul style="left: 0; top: 0;">
        <li><img src="img/Logo.png"></li>
        <li><a href="index.html">Home</a></li>
        <li><a href="awards.html">Awards</a></li>
        <li><a href="music.html">Music</a></li>
        <li><a href="artists.html">Artists</a></li>
		<li><a href="input.html">User Input</a></li>
    </ul>
    <h2 style="padding-left: 260px; padding-right: 200px; padding-top: 150px">
    Here is more information about this winner of the visual award:
	</h2>
    <section style="padding-top: 50px; padding-left: 200px; padding-right: 20px">
        <!-- construction of the table -->
        <table style="width:80%">
            <tr>
                <th>Winner</th>
                <th>Prize</th>
            </tr>
            <?php
            if (isset($result) && $result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rows['winner_visual'];?></td>
                        <td><?php echo $rows['visual_title'];?></td>
                    </tr>
                    <?php
                }
            } else {
                // No results
                ?>
                <tr>
                    <td colspan="2">No results found.</td>
                </tr>
                <?php
            }
            $conn->close();
            ?>
        </table>
    </section>
</body>
</html>
