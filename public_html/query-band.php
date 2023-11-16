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
    <h1 style="padding-top: 170px; padding-left: 200px;"> Succesfully added!</h1>
    <?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $servername = "localhost";
    $username = "mborsos";
    $password = "y0WmsG";
    $dbname = "Group-11";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $id = rand(1, 9999);


    // Insert into the Artist table first
    $sql2 = "INSERT INTO Artist (artist_id, is_winner_artist) VALUES (?, 0)";
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param("i", $id);

    if ($stmt2->execute()) {
        $stmt2->close();

        // Now insert into the Band table
        $sql1 = "INSERT INTO Band (band_id, members_number, band_name) VALUES (?, ?, ?)";
        $stmt1 = $conn->prepare($sql1);
        $stmt1->bind_param("iis", $id, $_POST["members_number"], $_POST["band_name"]);

        if ($stmt1->execute()) {
            // Continue with the rest of your code
        } else {
            echo "Error: " . $stmt1->error;
        }

        $stmt1->close();
    } else {
        echo "Error: " . $stmt2->error;
    }

    // Now retrieve and display the results
        $sql = "SELECT * FROM Band";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            ?>
            <section style="padding-top: 30px; padding-left: 200px; padding-right: 20px">
                <table style="width:80%">
                    <tr>
                        <th>Band Name</th>
                        <th>Number of Members</th>
                    </tr>
                    <?php
                    while ($rows = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $rows['band_name'];?></td>
                            <td><?php echo $rows['members_number'];?></td>
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

    $conn->close();
    ?>
    <div style="padding-left: 800px; padding-top: 70px">
        <button type="button"><a href="input.html">Go back!</a></button>
    </div></body>
</html>