<?php include 'config.php'; ?>
<link rel="stylesheet" href="style.css">

<div class="container">
<h1>🛍 Merch</h1>
<a href="merch_form.php" class="btn">+ Add Merch</a>

<div class="merch-grid">
<?php
$q=$conn->query("
SELECT merch.*,games.title AS game,categories.name AS category
FROM merch
JOIN games ON merch.game_id=games.id
JOIN categories ON merch.category_id=categories.id
");

while($row=$q->fetch_assoc()):
?>
<div class="merch-card">
<img src="uploads/<?= $row['image'] ?>">
<h4><?= $row['name'] ?></h4>
<p><?= $row['game'] ?> • <?= $row['category'] ?></p>

<a href="game_detail.php?id=<?= $row['game_id'] ?>" class="btn">Game</a>
<a href="merch_form.php?id=<?= $row['id'] ?>" class="btn">Edit</a>
<a href="merch_action.php?delete=<?= $row['id'] ?>" class="btn">Delete</a>
</div>
<?php endwhile; ?>
</div>
</div>