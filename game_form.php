<?php include 'config.php';
$id = $_GET['id'] ?? null;
if ($id) {
    $data = $conn->query("SELECT * FROM games WHERE id=$id")->fetch_assoc();
}
?>
<link rel="stylesheet" href="style.css">

<form action="game_action.php" method="POST" enctype="multipart/form-data" class="container">
<h2><?= $id ? "Edit Game" : "Add Game" ?></h2>

<input type="hidden" name="id" value="<?= $id ?>">

<input name="title" placeholder="Title" value="<?= $data['title'] ?? '' ?>">
<input name="developer" placeholder="Developer" value="<?= $data['developer'] ?? '' ?>">
<input name="genre" placeholder="Genre" value="<?= $data['genre'] ?? '' ?>">
<input name="year" placeholder="Year" value="<?= $data['release_year'] ?? '' ?>">

<input type="file" name="image">

<button class="btn"><?= $id ? "Update" : "Create" ?></button>
</form>