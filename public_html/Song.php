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
if (isset($_GET['song_id'])) {
    $id = $_GET['song_id'];

    if( $id > 10000 )
    {
    $sql = $conn->prepare("SELECT song_id, song_title, version, genre, language, name, surname, is_winner_song
    FROM Song, Music, CREATES, Singer
    WHERE CREATES.music_id = Song.song_id
    AND CREATES.artist_id = Singer.singer_id 
    AND Song.song_id = Music.music_id
    AND Song.song_id = ?");
    $sql->bind_param("i", $id);
    $sql->execute();
    $result = $sql->get_result();

    $stmt = $conn->prepare("SELECT song_id, song_title, version, genre, language, band_name, is_winner_song
    FROM Song, Music, CREATES, Band
    WHERE CREATES.music_id = Song.song_id
    AND CREATES.artist_id = Band.band_id 
    AND Song.song_id = Music.music_id
    AND Song.song_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result1 = $stmt->get_result();
    } else {
        $sql2 = $conn->prepare("SELECT song_title, version, genre, language, is_winner_song
                FROM Song, Music
                WHERE Song.song_id = Music.music_id
                AND Song.song_id = ?");
        $sql2->bind_param("i", $id);
        $sql2->execute();
        $result2 = $sql2->get_result();
    }


    // Check for errors
    if ($conn->error) {
        die("Error executing query. Please try again later.");
    }
} else {
    // 'award_id' is not set, handle it accordingly (redirect, show an error, etc.)
    die("No 'song_id' provided in the URL.");
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
    Here is more information about the selected song:
	</h2>
    <section style="padding-top: 50px; padding-left: 200px; padding-right: 20px">
        <!-- construction of the table -->
        <table style="width:80%">
            <tr>
                <th>Song</th>
                <th>Version</th>
                <th>Genre</th>
                <th>Language</th>
                <th>Artist</th>
            </tr>
            <?php
            if( $id > 10000 )
            {
            while ($rows = $result->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rows['song_title'];?></td>
                        <td><?php echo $rows['version'];?></td>
                        <td><?php echo $rows['genre'];?></td>
                        <td><?php echo $rows['language'];?></td>
                        <td><?php echo $rows['name'] . ' ' . $rows['surname'];?></td>
                    </tr>
                    <?php
                }
                while ($rows1 = $result1->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $rows1['song_title'];?></td>
                            <td><?php echo $rows1['version'];?></td>
                            <td><?php echo $rows1['genre'];?></td>
                            <td><?php echo $rows1['language'];?></td>
                            <td><?php echo $rows1['band_name'];?></td>
                        </tr>
                        <?php
                    }
            } else
            {
                while ($rows2 = $result2->fetch_assoc()) {
                    ?>
                    <tr>
                        <td><?php echo $rows2['song_title'];?></td>
                        <td><?php echo $rows2['version'];?></td>
                        <td><?php echo $rows2['genre'];?></td>
                        <td><?php echo $rows2['language'];?></td>
                        <td>unknown</td>
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
