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

<!-- NAVBAR -->
<div class="header">
  <div class="logo">GimList</div>

  <nav class="nav-center">
    <a href="index.php#games">Games</a>
    <a href="index.php#merch">Merch</a>
    <a href="index.php#add">Submit</a>
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

<!-- CONTENT -->
<div class="container">

  <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px;">
    <h1>🛍 Merchandise</h1>

    <?php if(isset($_SESSION['user'])) { ?>
      <a href="merch_form.php" class="btn">+ Add Merch</a>
    <?php } ?>
  </div>

  <div class="grid">
  <?php
  $q = $conn->query("
    SELECT merch.*, games.title AS game, categories.name AS category
    FROM merch
    JOIN games ON merch.game_id = games.id
    JOIN categories ON merch.category_id = categories.id
  ");

  while($row = $q->fetch_assoc()):
  ?>
    <div class="card">

      <img src="uploads/<?= $row['image'] ?>">

      <h3><?= $row['name'] ?></h3>
      <p><?= $row['game'] ?> • <?= $row['category'] ?></p>

      <!-- ACTIONS -->
      <div style="margin-top:10px;">
        <a href="game_detail.php?id=<?= $row['game_id'] ?>" class="btn">Game</a>

        <?php if(isset($_SESSION['user'])) { ?>
          <a href="merch_form.php?id=<?= $row['id'] ?>" class="btn">Edit</a>

          <a href="merch_action.php?delete=<?= $row['id'] ?>"
             class="btn"
             onclick="return confirm('Delete this merch?')">
             Delete
          </a>
        <?php } ?>
      </div>

    </div>
  <?php endwhile; ?>
  </div>

</div>

</body>
</html>