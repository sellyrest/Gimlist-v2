<?php 
session_start();
include 'config.php';

$games = mysqli_query($conn,"
  SELECT games.*, users.name AS publisher
  FROM games
  LEFT JOIN users ON games.user_id = users.id
  ORDER BY games.id DESC
");
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

    <?php if(isset($_SESSION['user'])) { ?>
      <span class="nav-user">👋 <?= $_SESSION['user']['name']; ?></span>
      <a href="logout.php" class="btn-outline">Logout</a>
    <?php } else { ?>
      <a href="login.php" class="btn-outline">Login</a>
    <?php } ?>

    <!-- ADD DROPDOWN -->
    <?php if(isset($_SESSION['user'])) { ?>
    <div class="dropdown" id="addMenu">
      <button class="btn" onclick="toggleDropdown()">+ Add ▾</button>
      <div class="dropdown-menu">
        <a href="game_form.php">🎮 Add Game</a>
        <a href="merch_form.php">🛍 Add Merch</a>
      </div>
    </div>
    <?php } ?>

  </div>
</div>

<div class="container">

  <div class="page-header">
    <h2>All Games</h2>
  </div>

  <div class="grid">

  <?php while($g = mysqli_fetch_assoc($games)) { ?>
    <div class="card">

      <img src="uploads/<?= $g['image']; ?>">

      <h3><?= $g['title']; ?></h3>
      <p><?= $g['genre']; ?></p>
      <p style="color:#94a3b8;font-size:13px;">
        👤 <?= $g['publisher'] ?? 'Unknown'; ?>
      </p>

      <a class="btn" href="game_detail.php?id=<?= $g['id']; ?>">Detail</a>

      <!-- OWNER ONLY -->
      <?php if(isset($_SESSION['user']) && $_SESSION['user']['id'] == $g['user_id']) { ?>
        <a href="game_form.php?id=<?= $g['id']; ?>" class="btn">Edit</a>

        <a href="game_action.php?delete=<?= $g['id']; ?>"
           class="btn"
           onclick="return confirm('Delete this game?')">
           Delete
        </a>
      <?php } ?>

    </div>
  <?php } ?>

  </div>

</div>

<script>
function toggleDropdown(){
  document.getElementById("addMenu").classList.toggle("active");
}

document.addEventListener("click", function(e){
  const menu = document.getElementById("addMenu");
  if(menu && !menu.contains(e.target)){
    menu.classList.remove("active");
  }
});
</script>

</body>
</html>