<?php
session_start(); // keep session if you want user info
include 'config.php';

$id = $_GET['id'];
$res = mysqli_query($conn,"SELECT * FROM games WHERE id=$id");
$g = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html>
<head>
<title><?php echo $g['title']; ?> - GimList</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<!-- NAVBAR -->
<div class="header">
  <div class="logo">🎮 GimList</div>

  <nav class="nav-center">
    <a href="index.php">Home</a>
    <a href="games.php">Games</a>
    <a href="merch.php">Merch</a>
  </nav>

  <div class="nav-right">
    <?php if(isset($_SESSION['user'])) { ?>
      <span>👋 <?php echo $_SESSION['user']['name']; ?></span>
      <a href="logout.php" class="btn-outline">Logout</a>
    <?php } else { ?>
      <a href="login.php" class="btn-outline">Login</a>
    <?php } ?>
  </div>
</div>

<div class="container">

  <div class="card" style="max-width:600px; margin:auto;">

    <img src="uploads/<?php echo $g['image']; ?>">

    <h2><?php echo $g['title']; ?></h2>

    <p><b>Genre:</b> <?php echo $g['genre']; ?></p>
    <p><b>Developer:</b> <?php echo $g['developer']; ?></p>

  </div>

</div>

</body>
</html>