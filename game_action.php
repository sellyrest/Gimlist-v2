<?php
include 'config.php';

$title = $_POST['title'];
$dev   = $_POST['developer'];
$genre = $_POST['genre'];
$year  = $_POST['year'];

/* FILE */
$file = $_FILES['image'];
$name = $file['name'];
$tmp  = $file['tmp_name'];
$size = $file['size'];
$error= $file['error'];

/* SETTINGS */
$maxSize = 2 * 1024 * 1024; // 2MB limit
$allowed = ['jpg','jpeg','png','webp'];

/* VALIDATION */
$ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

if($error !== 0){
  die("Upload error.");
}

if($size > $maxSize){
    echo "<script>alert('Image too large (max 2MB)');history.back();</script>";
    exit;
  }

  if(!in_array($ext, $allowed)){
    echo "<script>alert('Invalid file type! Only JPG, PNG, WEBP allowed');history.back();</script>";
    exit;
  }

/* RENAME FILE */
$newName = time() . "_" . uniqid() . "." . $ext;

/* MOVE FILE */
move_uploaded_file($tmp, "uploads/" . $newName);

/* INSERT */
mysqli_query($conn, "INSERT INTO games(title, developer, genre, release_year, image)
VALUES('$title','$dev','$genre','$year','$newName')");

header("Location: games.php");
exit;