<?php include 'config.php';
$id=$_GET['id'];

$game=$conn->query("SELECT * FROM games WHERE id=$id")->fetch_assoc();

$merch=$conn->query("
SELECT merch.*, categories.name AS category
FROM merch
JOIN categories ON merch.category_id=categories.id
WHERE merch.game_id=$id
");
?>
<link rel="stylesheet" href="style.css">

<div class="container">

<h1><?= $game['title'] ?></h1>

<img src="uploads/<?= $game['image'] ?>" width="300">

<p><?= $game['developer'] ?></p>
<p><?= $game['genre'] ?></p>

<a href="merch_form.php?game_id=<?= $id ?>" class="btn">+ Add Merch</a>

<?php if($merch->num_rows>0): ?>
<h2>🛍 Related Merch</h2>

<div class="merch-grid">
<?php while($m=$merch->fetch_assoc()): ?>
<div class="merch-card">
    <img src="uploads/<?= $m['image'] ?>">
    <h4><?= $m['name'] ?></h4>
    <p><?= $m['category'] ?></p>
    <p>Rp<?= number_format($m['price']) ?></p>
</div>
<?php endwhile; ?>
</div>
<?php endif; ?>

<a href="games.php" class="btn">Back</a>
</div>