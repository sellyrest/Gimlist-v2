<?php 
include 'config.php';
include 'auth.php';

$id = $_GET['id'] ?? null;
$data = null;

if($id){
  $id = (int)$id; // safety
  $data = $conn->query("SELECT * FROM merch WHERE id=$id")->fetch_assoc();
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $id ? "Edit" : "Add" ?> Merch - GimList</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<!-- NAVBAR -->
<div class="header">
  <div class="logo">🎮 GimList</div>

  <nav class="nav-center">
    <a href="index.php">Home</a>
    <a href="games.php">Games</a>
    <a href="merch.php" class="active">Merch</a>
  </nav>
</div>

<div class="container">

  <div class="page-header">
    <h2><?= $id ? "✏️ Edit Merch" : "🛍 Add Merch" ?></h2>
    <p>Fill the details below</p>
  </div>

  <form action="merch_action.php" method="POST" enctype="multipart/form-data" class="form-box">

    <input type="hidden" name="id" value="<?= $id ?>">

    <!-- NAME -->
    <input name="name" 
           value="<?= htmlspecialchars($data['name'] ?? '') ?>" 
           placeholder="Merch Name" required>

    <!-- PRICE -->
    <input name="price" 
           type="number"
           value="<?= htmlspecialchars($data['price'] ?? '') ?>" 
           placeholder="Price (Rp)" required>

    <!-- GAME SELECT -->
    <select name="game_id" required>
      <option value="">Select Game</option>
      <?php
      $selectedGame = $_GET['game_id'] ?? ($data['game_id'] ?? null);
      $g = $conn->query("SELECT * FROM games");

      while($row = $g->fetch_assoc()):
      ?>
        <option value="<?= $row['id'] ?>" 
          <?= ($row['id'] == $selectedGame) ? 'selected' : '' ?>>
          <?= htmlspecialchars($row['title']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <!-- CATEGORY SELECT -->
    <select name="category_id" required>
      <option value="">Select Category</option>
      <?php
      $selectedCat = $data['category_id'] ?? null;
      $c = $conn->query("SELECT * FROM categories");

      while($row = $c->fetch_assoc()):
      ?>
        <option value="<?= $row['id'] ?>"
          <?= ($row['id'] == $selectedCat) ? 'selected' : '' ?>>
          <?= htmlspecialchars($row['name']) ?>
        </option>
      <?php endwhile; ?>
    </select>

    <!-- CURRENT IMAGE -->
    <?php if($id && !empty($data['image'])): ?>
      <div style="margin:10px 0;">
        <p style="font-size:14px;color:#94a3b8;">Current Image:</p>

        <img src="/uploads/<?= htmlspecialchars($data['image']) ?>" 
             style="width:100%;max-width:200px;border-radius:10px;">
      </div>
    <?php endif; ?>

    <!-- UPLOAD -->
    <input type="file" name="image" id="imgInput"
           accept=".jpg,.jpeg,.png,.webp">

    <!-- PREVIEW -->
    <img id="preview"
         style="margin-top:10px;max-width:200px;border-radius:10px;display:none;">

    <button class="btn"><?= $id ? "Update" : "Create" ?></button>

  </form>

</div>

<!-- LIVE PREVIEW -->
<script>
document.getElementById('imgInput').onchange = function(e){
  const file = e.target.files[0];

  if(file){
    const reader = new FileReader();

    reader.onload = function(ev){
      const img = document.getElementById('preview');
      img.src = ev.target.result;
      img.style.display = 'block';
    }

    reader.readAsDataURL(file);
  }
}
</script>

</body>
</html>