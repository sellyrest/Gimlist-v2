<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
  echo "login";
  exit;
}

$user_id = $_SESSION['user']['id'];
$game_id = $_POST['game_id'];
$rating = $_POST['rating'];

$check = $conn->query("SELECT * FROM ratings WHERE user_id=$user_id AND game_id=$game_id");

if($check->num_rows > 0){
  $conn->query("UPDATE ratings SET rating=$rating 
  WHERE user_id=$user_id AND game_id=$game_id");
} else {
  $conn->query("INSERT INTO ratings(user_id,game_id,rating)
  VALUES($user_id,$game_id,$rating)");
}

echo "ok";
?>