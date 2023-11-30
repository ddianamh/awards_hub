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

// Check if 'band_id' is set in the URL
if (isset($_GET['band_id'])) {
    $id = $_GET['band_id'];

    if( $id > 30000 ){
        $sql = $conn->prepare("SELECT band_id, band_name, members_number, is_winner_artist
        FROM Artist, Band
        WHERE Artist.artist_id = Band.band_id        
        AND Band.band_id = ?");
        $sql->bind_param("i", $id);
        $sql->execute();
        $result = $sql->get_result();
    } else {
        $sql1 = $conn->prepare("SELECT band_id, band_name, members_number, is_winner_artist
        FROM Artist, Band
        WHERE Artist.artist_id = Band.band_id        
        AND Band.band_id = ?");
        $sql1->bind_param("i", $id);
        $sql1->execute();
        $result1 = $sql1->get_result();
    }


    // Check for errors
    if ($conn->error) {
        die("Error executing query. Please try again later.");
    }
} else {
    // 'award_id' is not set, handle it accordingly (redirect, show an error, etc.)
    die("No 'band_id' provided in the URL.");
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
        <a href="imprintpage.html" style="margin-left: 70px;">Band you selected:</a>
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
    Here is more information about the selected band:
	</h2>
    <section style="padding-top: 50px; padding-left: 200px; padding-right: 20px">
        <!-- construction of the table -->
        <table style="width:80%">
            <tr>
                <th>Band</th>
                <th>No. of Members</th>
                <th>State</th>
            </tr>
            <?php
            if( $id > 30000 ){
            while ($rows = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rows['band_name'] ?></td>
                        <td><?php echo $rows['members_number'] ?></td>
                        <td><?php if( $rows['is_winner_artist'] == 1 )
                            echo "Winner";
                        else
                            echo "Nominee";
                        ?></td>
                    </tr>
                    <?php
                }
            } else {
                while ($rows1 = $result1->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rows1['band_name'] ?></td>
                        <td><?php echo $rows1['members_number'] ?></td>
                        <td>User Input</td>
                    </tr>
                    <?php
                }
            }
            $conn->close();
            ?>
        </table>
    </section>
</body>
</html>
