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
<ul>
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


$sql1 = "INSERT INTO Art_Award (award_id, year) VALUES (?, ?)";
$stmt1 = $conn->prepare($sql1);
$stmt1->bind_param("ii", $id, $_POST["year"]);


$sql2 = "INSERT INTO Album_Award (award_id, winner_album, album_prize) VALUES (?, ?, ?)";
$stmt2 = $conn->prepare($sql2);
$stmt2->bind_param("iss", $id, $_POST["winner_album"], $_POST["album_prize"]);


// Execute the prepared statements
if ($stmt1->execute() && $stmt2->execute()) {
$stmt1->close();
$stmt2->close();


// Now retrieve and display the results
$sql = "SELECT * FROM Album_Award JOIN Art_Award ON award_id = award_id";
$result = $conn->query($sql);


if ($result->num_rows > 0) {
?>
<section style="padding-top: 30px; padding-left: 200px; padding-right: 20px">
<table style="width:80%">
<tr>
<th>Winner Album</th>
<th>Album Prize</th>
<th>Year</th>
</tr>
<?php
while ($rows = $result->fetch_assoc()) {
?>
<tr>
<td><?php echo $rows['winner_album'];?></td>
<td><?php echo $rows['album_prize'];?></td>
<td><?php echo $rows['year'];?></td>
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
}


$conn->close();
?>
<div style="padding-left: 800px">
<button type="button"><a href="input.html">Go back!</a></button>
</div>
</body>
</html>