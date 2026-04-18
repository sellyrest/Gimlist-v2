<?php include 'auth.php'; ?>
<?php include 'config.php';

$id=$_GET['id']??null;
if($id){
$data=$conn->query("SELECT * FROM merch WHERE id=$id")->fetch_assoc();
}
?>
<link rel="stylesheet" href="/assets/style.css">

<form action="merch_action.php" method="POST" enctype="multipart/form-data" class="container">

<input type="hidden" name="id" value="<?= $id ?>">

<input name="name" value="<?= $data['name']??'' ?>" placeholder="Name">
<input name="price" value="<?= $data['price']??'' ?>" placeholder="Price">

<select name="game_id">
<?php
$selected=$_GET['game_id']??$data['game_id']??null;
$g=$conn->query("SELECT * FROM games");
while($row=$g->fetch_assoc()):
?>
<option value="<?= $row['id'] ?>" <?=($row['id']==$selected)?'selected':''?>>
<?= $row['title'] ?>
</option>
<?php endwhile; ?>
</select>

<select name="category_id">
<?php
$c=$conn->query("SELECT * FROM categories");
while($row=$c->fetch_assoc()):
?>
<option value="<?= $row['id'] ?>"><?= $row['name'] ?></option>
<?php endwhile; ?>
</select>

<input type="file" name="image">

<button class="btn"><?= $id?"Update":"Create" ?></button>
</form>