<!DOCTYPE html>
<html>
<head>
   <link rel="stylesheet" type="text/css" href="style.css">
</head>
 <?php  

 session_start();  
 if(isset($_SESSION["user_name"]))  
 {  
      echo '<h3 style="padding-top: 150px; padding-left: 260px">Login Success, Welcome '.$_SESSION["user_name"].'!</h3>';
      echo '<br /><a href="logout.php" style="color: white; padding-left: 260px">Logout</a>';  
 }  
 else  
 {  
      header("location:login.php");  
 }  
 ?>   
<body>
    <div class="topnav" style="background-color: #5c2626; height: 12%;">
        <a href="imprintpage.html" style="margin-left: 70px;">Logged in!</a>
    </div>
    <ul style="left: 0; top: 0;">
        <li><img src="img/Logo.png"></li>
        <li><a href="index.html">Home</a></li>
        <li><a href="awards.html">Awards</a></li>
        <li><a href="music.html">Music</a></li>
        <li><a href="artists.html">Artists</a></li>
		<li><a href="login.php">User Input</a></li>
    </ul>
   <h1 style="padding-bottom: 15px; padding-left: 260px">
       Choose what you want to do:
   </h1>
   <div style="padding-left: 300px;">
        <li><a href="song.html">Add Songs</a></li>
        <li><a href="album.html">Add Albums</a></li>
        <li><a href="singer.html">Add Singers</a></li>
        <li><a href="band.html">Add Bands</a></li>
        <li><a href="song_award.html">Add Song Awards</a></li>
        <li><a href="album_award.html">Add Album Awards</a></li>
        <li><a href="artist_award.html">Add Artist Awards</a></li>
        <li><a href="visual_award.html">Add Visual Awards</a></li>
        <li><a href="won_by.html">Add an ideal song winner</a></li>
        <li><a href="belongs_to.html">Add an ideal album winner</a></li>
        <li><a href="receives.html">Add an ideal artist winner</a></li>
        <li><a href="gets.html">Add an ideal visual winner</a></li>
   </div>
</body>
</html>



å
