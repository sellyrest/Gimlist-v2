<?php
session_start();
include 'config.php';

if(!isset($_SESSION['user'])){
  echo "login";
  exit;
}

$user_id = $_SESSION['user']['id'];
$game_id = $_POST['game_id'];
$comment = $_POST['comment'];

$conn->query("INSERT INTO comments(user_id,game_id,comment)
VALUES('$user_id','$game_id','$comment')");

echo "ok";
?>