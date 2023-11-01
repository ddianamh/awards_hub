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
    <ul>
        <li><img src="img/Logo.png"></li>
        <li><a href="index.html">Home</a></li>
        <li><a href="awards.html">Awards</a></li>
        <li><a href="music.html">Music</a></li>
        <li><a href="artists.html">Artists</a></li>
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
        
        $year = $_POST["year"];
        
        $sql = "SELECT winner_song, song_prize, year FROM Song_Award LEFT JOIN Award ON Award.award_id = Song_Award.award_id WHERE year = $year;";
        $result = $conn->query($sql);

        // $sql = "SELECT * FROM Orders LIMIT 30";
        // $sql = "UPDATE MyGuests SET lastname='Doe' WHERE id=2";
    ?>
    <section style="padding-top: 200px; padding-left: 200px; padding-right: 20px">
        <!-- constructia tabelului -->
        <table style="width:80%">
        <tr>
        <th>Winner Song</th>
        <th>Song Prize</th>
        </tr>
        <?php 
        if ($result->num_rows <= 0) {
            ?>
            <tr>
            <td><?php echo "No results!";?></td>
            </tr>
            <?php
        }
        else {    
        while($rows=$result->fetch_assoc())
            {
            ?>
            <tr>
            <td><?php echo $rows['winner_song'];?></td>
            <td><?php echo $rows['song_prize'];?></td>
            </tr>
            <?php
            }
        }
        ?>
        </table>
    </section>
</body>
</html>