<?php include 'config.php'; ?>
<link rel="stylesheet" href="style.css">

<div class="container">
<h1>🎮 Games</h1>
<a href="game_form.php" class="btn">+ Add Game</a>

<div class="game-row">
<?php
$result = $conn->query("SELECT * FROM games ORDER BY id DESC");
while($row = $result->fetch_assoc()):
?>
<div class="game-card">
    <img src="uploads/<?= $row['image'] ?>">
    <h5><?= $row['title'] ?></h5>
    <p><?= $row['genre'] ?> • <?= $row['release_year'] ?></p>

    <a href="game_detail.php?id=<?= $row['id'] ?>" class="btn">View</a>
    <a href="game_form.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
    <a href="game_action.php?delete=<?= $row['id'] ?>" class="btn">Delete</a>
</div>
<?php endwhile; ?>
</div>
</div>