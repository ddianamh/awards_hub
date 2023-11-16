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
if (isset($_GET['song_prize'])) {
    $prize = $_GET["song_prize"];
    $sql = "SELECT winner_song, song_prize, year, Song_Award.award_id FROM Song_Award LEFT JOIN Award ON Award.award_id = Song_Award.award_id WHERE song_prize = '$prize' AND Song_Award.award_id LIKE '%S%';";
    $result = $conn->query($sql);

    // Check for errors
    if ($conn->error) {
        die("Error executing query. Please try again later.");
    }
} else {
    if (isset($_GET['artist_title'])) {
        $prize = $_GET["artist_title"];
        $sql1 = "SELECT winner_artist, artist_title, year, Artist_Award.award_id FROM Artist_Award LEFT JOIN Award ON Award.award_id = Artist_Award.award_id WHERE artist_title = '$prize' AND Album_Award.award_id LIKE '%A%';";
        $result1 = $conn->query($sql1);
    
        // Check for errors
        if ($conn->error) {
            die("Error executing query. Please try again later.");
        }
    } else {
        if (isset($_GET['album_prize'])) {
            $prize = $_GET["album_prize"];
            $sql2 = "SELECT winner_album, album_prize, year, Album_Award.award_id FROM Album_Award LEFT JOIN Award ON Award.award_id = Album_Award.award_id WHERE album_prize = '$prize' AND Artist_Award.award_id LIKE '%M%';";
            $result2 = $conn->query($sql2);
        
            // Check for errors
            if ($conn->error) {
                die("Error executing query. Please try again later.");
            }
        } else {
            if (isset($_GET['visual_title'])) {
                $prize = $_GET["visual_title"];
                $sql3 = "SELECT winner_visual, visual_title, year, Visual_Award.award_id FROM Visual_Award LEFT JOIN Award ON Award.award_id = Visual_Award.award_id WHERE visual_title = '$prize' AND Visual_Award.award_id LIKE '%V%';";
                $result3 = $conn->query($sql3);
            
                // Check for errors
                if ($conn->error) {
                    die("Error executing query. Please try again later.");
                }
            } 
        }
    }
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
        The selected award had the following winners over the years:
	</h2>
    <section style="padding-top: 50px; padding-left: 200px; padding-right: 20px">
        <!-- construction of the table -->
        <table style="width:80%">
            <tr>
                <th>Winner</th>
                <th>Prize</th>
                <th>Year</th>
            </tr>
            <?php
            if (isset($result) && $result->num_rows > 0) {
                while ($rows = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rows['winner_song'];?></td>
                        <td><?php echo $rows['song_prize'];?></td>
                        <td><?php echo $rows['year'];?></td>
                    </tr>
                    <?php
                }
            } else {
                if (isset($result1) && $result1->num_rows > 0) {
                    while ($rows1 = $result1->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $rows1['winner_artist'];?></td>
                            <td><?php echo $rows1['artist_title'];?></td>
                            <td><?php echo $rows1['year'];?></td>
                        </tr>
                        <?php
                    }
                } else {
                    if (isset($result2) && $result2->num_rows > 0) {
                        while ($rows2 = $result2->fetch_assoc()) {
                            ?>
                            <tr>
                                <td><?php echo $rows2['winner_album'];?></td>
                                <td><?php echo $rows2['album_prize'];?></td>
                                <td><?php echo $rows2['year'];?></td>
                            </tr>
                            <?php
                        }
                    } else {
                        if (isset($result3) && $result3->num_rows > 0) {
                            while ($rows3 = $result3->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td><?php echo $rows3['winner_visual'];?></td>
                                    <td><?php echo $rows3['visual_title'];?></td>
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
                    }
                }
            }
            $conn->close();
            ?>
        </table>
    </section>
</body>
</html>
