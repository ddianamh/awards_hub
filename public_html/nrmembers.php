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
        <a href="imprintpage.html" style="margin-left: 70px;">Artists:</a>
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
        
        $number = $_POST["number"];
        if( $number > 1 ){
            $sql = "SELECT band_id, band_name, members_number
            FROM Band 
            GROUP BY band_name
            HAVING members_number = $number
            ORDER BY members_number DESC;";
            $result = $conn->query($sql);
        } else {
            $sql1 = "SELECT singer_id, name, surname FROM Singer
            ORDER BY singer_id DESC;";
            $result1 = $conn->query($sql1);
        }
    ?>
    <section style="padding-top: 150px; padding-left: 200px; padding-right: 20px">
        <table style="width:80%">
        <?php 
        if ($result->num_rows <= 0 && $result1->num_rows <= 0) {
            ?>
            <tr>
            <th>Band Name</th>
            </tr>
            <tr>
            <td><?php echo "No results!";?></td>
            </tr>
            <?php
        }
        else {    
        if ($result->num_rows > 0 ) {
            ?>
                <h2 style="padding-left: 60px; padding-right: 200px; padding-bottom: 50px">
                Here is a list of bands with <?php echo $number?> members:
	            </h2>
            <tr>
            <th>Band Name</th>
            </tr>
            <?php
        while($rows=$result->fetch_assoc())
            {
            ?>
            <tr>
            <td><?php echo "<a style='color:white;' href='Band.php?band_id=".$rows['band_id']."'>".$rows['band_name']."</a>";?></td>
            </tr>
            <?php
        }}
        if ($result1->num_rows > 0 ) {
            ?>
            <h2 style="padding-left: 60px; padding-right: 200px; padding-bottom: 50px">
            Here is a list of solo singers:
	        </h2>
            <tr>
            <th>Singers</th>
            </tr>
            <?php
        while($rows1=$result1->fetch_assoc())
            {
            ?>
            <tr>
            <td><?php echo "<a style='color:white;' href='Singer.php?singer_id=".$rows1['singer_id']."'>".$rows1['name'] . " " . $rows1['surname']."</a>";?></td>
            </tr>
            <?php
        }}
        }
        ?>
        </table>
    </section>
</body>
</html>