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
    $id = $_GET['award_id'];

    $sql = $conn->prepare("SELECT winner_album, version, genre, language, name, surname, album_prize, Album_Award.award_id
    FROM Album_Award, BELONGS_TO, Music, CREATES, Singer
    WHERE Album_Award.award_id = BELONGS_TO.award_id
    AND BELONGS_TO.album_id = Music.music_id
    AND CREATES.music_id = Music.music_id
    AND CREATES.artist_id = Singer.singer_id 
    AND Album_Award.award_id  = ?");
    $sql->bind_param("s", $id);
    $sql->execute();
    $result = $sql->get_result();

    $stmt = $conn->prepare("SELECT winner_album, version, genre, language, band_name, album_prize
    FROM Album_Award, BELONGS_TO, Music, CREATES, Band
    WHERE Album_Award.award_id = BELONGS_TO.award_id
    AND BELONGS_TO.album_id = Music.music_id
    AND CREATES.music_id = Music.music_id
    AND CREATES.artist_id = Band.band_id
    AND Album_Award.award_id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result1 = $stmt->get_result();

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
		<li><a href="login.php">Maintanance Page</a></li>
    </ul>
    <h2 style="padding-left: 260px; padding-right: 200px; padding-top: 150px">
    Here is more information about this winning album:
	</h2>
    <section style="padding-top: 50px; padding-left: 200px; padding-right: 20px">
        <!-- construction of the table -->
        <table style="width:80%">
            <tr>
                <th>Winner</th>
                <th>Version</th>
                <th>Genre</th>
                <th>Language</th>
                <th>Prize</th>
                <th>Artist</th>
            </tr>
            <?php
            
            while ($rows = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rows['winner_album'];?></td>
                        <td><?php echo $rows['version'];?></td>
                        <td><?php echo $rows['genre'];?></td>
                        <td><?php echo $rows['language'];?></td>
                        <td><?php echo $rows['album_prize'];?></td>
                        <td><?php echo $rows['name'];?></td>
                        <td><?php echo $rows['surname'];?></td>
                    </tr>
                    <?php
                }
                while ($rows1 = $result1->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $rows1['winner_album'];?></td>
                            <td><?php echo $rows1['version'];?></td>
                            <td><?php echo $rows1['genre'];?></td>
                            <td><?php echo $rows1['language'];?></td>
                            <td><?php echo $rows1['album_prize'];?></td>
                            <td><?php echo $rows1['band_name'];?></td>
                        </tr>
                        <?php
                    }
            $conn->close();
            ?>
        </table>
    </section>
</body>
</html>
