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
        <a href="imprintpage.html" style="margin-left: 70px;">Albums from the genre you selected:</a>
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
        
        $genre = $_POST["genre"];
        
        $sql = "SELECT album_title, genre, language, version FROM Album JOIN Music ON album_id = music_id WHERE upper(genre) = upper('$genre');";
        $result = $conn->query($sql);
    ?>
    <section style="padding-top: 200px; padding-left: 200px; padding-right: 20px">
        <table style="width:80%">
        <tr>
        <th>Album Title</th>
        <th>Language</th>
        <th>Version</th>
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
            <td><?php echo $rows['album_title'];?></td>
            <td><?php echo $rows['language'];?></td>
            <td><?php echo $rows['version'];?></td>
            </tr>
            <?php
            }
        }
        ?>
        </table>
    </section>
</body>
</html>