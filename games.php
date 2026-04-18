<?php 
session_start();
include 'config.php'; 
?>

<!DOCTYPE html>
<html>
<head>
<title>Games - GimList</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="header">
  <div class="logo">🎮 GimList</div>

  <nav class="nav-center">
    <a href="index.php">Home</a>
    <a href="games.php" class="active">Games</a>
    <a href="merch.php">Merch</a>
  </nav>

  <div class="nav-right">
    <a href="game_form.php" class="btn">+ Add</a>
  </div>
</div>

<div class="container">

  <div class="page-header">
    <h2>All Games</h2>
    <p>Browse Indonesian games 🎮</p>
  </div>

  <div class="grid">
    <?php
    $result = mysqli_query($conn, "SELECT * FROM games");

    if(mysqli_num_rows($result) == 0){
      echo "<p>No games found.</p>";
    }

    while($g = mysqli_fetch_assoc($result)) {
    ?>
      <div class="card">
        <img src="uploads/<?php echo $g['image']; ?>">
        <h3><?php echo $g['title']; ?></h3>
        <p><?php echo $g['genre']; ?></p>
        <a class="btn" href="game_detail.php?id=<?php echo $g['id']; ?>">Detail</a>
      </div>
    <?php } ?>
  </div>

</div>

</body>
</html>