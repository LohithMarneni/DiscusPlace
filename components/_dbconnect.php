<?php
//script to connect to database
$servername="localhost";
  $username="root";
  $serverpassword="";
  $dbname= "discusplace";
  $conn=mysqli_connect($servername, $username, $serverpassword, $dbname);
  if(!$conn){
    die("Error Occured---->". mysqli_connect_error());
  }
?>