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
        
        $year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);;
        
        $sql = "SELECT winner_song, song_prize, year, Song_Award.award_id FROM Song_Award LEFT JOIN Award ON Award.award_id = Song_Award.award_id WHERE year = $year AND Song_Award.award_id LIKE '%S%'";
        $result = $conn->query($sql);

        $sql1 = "SELECT winner_album, album_prize, year, Album_Award.award_id FROM Album_Award LEFT JOIN Award ON Award.award_id = Album_Award.award_id WHERE year = $year AND Album_Award.award_id LIKE '%A%'";
        $result1 = $conn->query($sql1);

        $sql2 = "SELECT artist_title, winner_artist, year, Artist_Award.award_id FROM Artist_Award LEFT JOIN Award ON Award.award_id = Artist_Award.award_id WHERE year = $year AND Artist_Award.award_id LIKE '%M%'";
        $result2 = $conn->query($sql2);
        
        $sql3 = "SELECT winner_visual, visual_title, year, Visual_Award.award_id FROM Visual_Award LEFT JOIN Award ON Award.award_id = Visual_Award.award_id WHERE year = $year AND Visual_Award.award_id LIKE '%V%'";
        $result3 = $conn->query($sql3);

        // $sql = "SELECT * FROM Orders LIMIT 30";
        // $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
    ?>
    <section style="padding-top: 200px; padding-left: 200px; padding-right: 20px">
        <!-- constructia tabelului -->
        <table style="width:80%">
        <tr>
        <th>Winner</th>
        <th>Prize</th>
        </tr>
        <?php 
        if ($result->num_rows <= 0 && $result1->num_rows <= 0 && $result2->num_rows <= 0 && $result3->num_rows <= 0) {
            ?>
            <tr>
            <td><?php echo "No results!";?></td>
            </tr>
            <?php
        }
        else {   
        if($result->num_rows > 0){
            while($rows=$result->fetch_assoc())
                {
                    ?>
                    <tr>
                    <td><?php echo "<a style='color:white;' href='ASong.php?award_id=".$rows['award_id']."'>".$rows['winner_song']."</a>";?></td>
                    <td><?php echo "<a style='color:white;' href='Award.php?song_prize=".$rows['song_prize']."'>".$rows['song_prize']."</a>";?></td>
                    </tr>
                    <?php
                }
            }
        if($result1->num_rows > 0){
            while($rows1=$result1->fetch_assoc())
                {
                    ?>
                    <tr>
                    <td><?php echo "<a style='color:white;' href=AAlbum.php?award_id=".$rows1['award_id'].">".$rows1['winner_album']."</a>";?></td>
                    <td><?php echo "<a style='color:white;' href=Award.php?album_prize=".$rows1['album_prize'].">".$rows1['album_prize']."</a>";?></td>
                    </tr>
                    <?php
                }
            }
        if($result2->num_rows > 0){
            while($rows2=$result2->fetch_assoc())
                {
                    ?>
                    <tr>
                    <td><?php echo "<a style='color:white;' href=AArtist.php?award_id=".$rows2['award_id'].">".$rows2['winner_artist']."</a>";?></td>
                    <td><?php echo "<a style='color:white;' href=Award.php?artist_title=".$rows2['artist_title'].">".$rows2['artist_title']."</a>";?></td>
                    </tr>
                    <?php
                }
            }
        if($result3->num_rows > 0){
            while($rows3=$result3->fetch_assoc())
                {
                    ?>
                    <tr>
                    <td><?php echo "<a style='color:white;' href=AVisual.php?award_id=".$rows3['award_id'].">".$rows3['winner_visual']."</a>";?></td>
                    <td><?php echo "<a style='color:white;' href=Award.php?visual_title=".$rows3['visual_title'].">".$rows3['visual_title']."</a>";?></td>
                    </tr>
                    <?php
                }
            }
        }
        ?>
        </table>
    </section>
</body>
</html>