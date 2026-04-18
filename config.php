<?php
if(session_status() === PHP_SESSION_NONE){
  session_start();
}

$conn = mysqli_connect("localhost","root","","gimlist");

if(!$conn){
  die("Connection failed: " . mysqli_connect_error());
}
?>