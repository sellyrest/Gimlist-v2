<?php 
session_start();
include 'config.php'; 
?>

<!DOCTYPE html>
<html>
<head>
<title>Merch - GimList</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="header">
  <div class="logo">🎮 GimList</div>

  <nav class="nav-center">
    <a href="index.php#games">Games</a>
    <a href="merch.php" class="active">Merch</a>
  </nav>

  <div class="nav-right">
    <?php if(isset($_SESSION['user'])) { ?>
      <span class="nav-user">👋 <?= $_SESSION['user']['name']; ?></span>
      <a href="logout.php" class="btn-outline">Logout</a>
    <?php } else { ?>
      <a href="login.php" class="btn-outline">Login</a>
    <?php } ?>
  </div>
</div>

<div class="container">

  <div style="display:flex; justify-content:space-between;">
    <h1>🛍 Merchandise</h1>

    <?php if(isset($_SESSION['user'])) { ?>
      <a href="merch_form.php" class="btn">+ Add Merch</a>
    <?php } ?>
  </div>

  <div class="grid">

  <?php
  $q = $conn->query("
    SELECT merch.*, users.name AS publisher,
           games.title AS game
    FROM merch
    LEFT JOIN users ON merch.user_id = users.id
    LEFT JOIN games ON merch.game_id = games.id
  ");

  while($row = $q->fetch_assoc()):
  ?>

    <div class="card">

      <img src="uploads/<?= $row['image'] ?>">

      <h3><?= $row['name'] ?></h3>
      <p><?= $row['game'] ?></p>

      <p style="color:#94a3b8;font-size:13px;">
        👤 <?= $row['publisher']; ?>
      </p>

      <a href="game_detail.php?id=<?= $row['game_id'] ?>" class="btn">Game</a>

      <!-- OWNER ONLY -->
      <?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $row['user_id']) { ?>
        <a href="merch_form.php?id=<?= $row['id'] ?>" class="btn">Edit</a>

        <a href="merch_action.php?delete=<?= $row['id'] ?>"
           class="btn"
           onclick="return confirm('Delete this merch?')">
           Delete
        </a>
      <?php } ?>

    </div>

  <?php endwhile; ?>

  </div>
</div>

</body>
</html>