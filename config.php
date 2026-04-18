<?php
$conn = mysqli_connect("localhost", "root", "", "gimlist");

if (!$conn) {
  die("Connection failed: " . mysqli_connect_error());
}

session_start();
?>