<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
<title>Awards</title>
<style>
table {
margin: 0 auto;
font-size: large;
border: 1px solid black;
}

h1 {
text-align: center;
color: #c18f59;
font-size: xx-large;
font-weight: bold;
padding: 30px;
}

td {
border: 1px solid black;
margin: 10px;
}

th,
td {
font-weight: bold;
border: 1px solid black;
padding: 10px;
text-align: center;
margin: 10px;
}

td {
font-weight: lighter;
}
</style>
</head>
<body>
    <div class="topnav" style="background-color: #5c2626; height: 12%;">
    <a href="imprintpage.html" style="margin-left: 70px;">Input Feedback Page</a>
    </div>
    <ul style="left: 0; top: 0;">
    <li><img src="img/Logo.png"></li>
    <li><a href="index.html">Home</a></li>
    <li><a href="awards.html">Awards</a></li>
    <li><a href="music.html">Music</a></li>
    <li><a href="artists.html">Artists</a></li>
    <li><a class="active" href="input.html">User Input</a></li>
    </ul>
    <h1 style="padding-top: 170px; padding-left: 200px;"> Succesfully added! <h1>
    <?php
    $servername = "localhost";
    $username = "mborsos";
    $password = "y0WmsG";
    $dbname = "Group-11";


    $conn = new mysqli($servername, $username, $password, $dbname);


    if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
    }


    $id = rand(1, 9999);


    $sql1 = "INSERT INTO Music (music_id, version, genre, language) VALUES (?, ?, ?, ?)";
    $stmt1 = $conn->prepare($sql1);
    $stmt1->bind_param("isss", $id, $_POST["version"], $_POST["genre"], $_POST["language"]);


    $sql2 = "INSERT INTO Album (album_id, album_title, is_winner_album) VALUES (?, ?, 0)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("is", $id, $_POST["album_title"]);


    // Execute the prepared statements
    if ($stmt1->execute() && $stmt2->execute()) {
    $stmt1->close();
    $stmt2->close();


    // Now retrieve and display the results
    $sql = "SELECT * FROM Album JOIN Music ON album_id = music_id";
    $result = $conn->query($sql);


    if ($result->num_rows > 0) {
        ?>
        <section style="padding-top: 30px; padding-left: 200px; padding-right: 20px">
        <table style="width:80%">
        <tr>
        <th>Album Title</th>
        <th>Genre</th>
        <th>Language</th>
        <th>Version</th>
        </tr>
        <?php
        while ($rows = $result->fetch_assoc()) {
        ?>
        <tr>
        <td><?php echo $rows['album_title'];?></td>
        <td><?php echo $rows['genre'];?></td>
        <td><?php echo $rows['language'];?></td>
        <td><?php echo $rows['version'];?></td>
        </tr>
        <?php
        }
        ?>
        </table>
        </section>
        <?php
        } else {
        echo "No results found.";
        }
        } else {
            echo "Error: " . $stmt1->error . " " . $stmt2->error;
        }


        $conn->close();
        ?>
    <button type="button"><a href="input.html">Go back!</a></button>
</body>
</html>
