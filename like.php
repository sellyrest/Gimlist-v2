<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
  echo "login";
  exit;
}

$user_id = $_SESSION['user']['id'];
$game_id = $_POST['game_id'];

$check = $conn->query("SELECT * FROM likes WHERE user_id=$user_id AND game_id=$game_id");

if($check->num_rows > 0){
  $conn->query("DELETE FROM likes WHERE user_id=$user_id AND game_id=$game_id");
  echo "unliked";
} else {
  $conn->query("INSERT INTO likes(user_id,game_id) VALUES($user_id,$game_id)");
  echo "liked";
}
?>