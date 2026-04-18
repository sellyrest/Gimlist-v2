<?php
session_start();
include 'config.php';

/* MUST LOGIN */
if(!isset($_SESSION['user'])){
  echo "<script>alert('Login required');location='login.php';</script>";
  exit;
}

/* EDIT MODE */
$id = $_GET['id'] ?? null;
$data = null;

if($id){
  $user_id = $_SESSION['user']['id'];

  $res = $conn->query("SELECT * FROM games WHERE id=$id AND user_id=$user_id");
  $data = $res->fetch_assoc();

  if(!$data){
    echo "<script>alert('Unauthorized');location='games.php';</script>";
    exit;
  }
}
/* UPLOAD IMAGE */
$filename = '';

if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){

  $allowed = ['jpg','jpeg','png','webp'];

  $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

  if(!in_array($ext, $allowed)){
    die("Only JPG, PNG, WEBP allowed!");
  }

  // create unique filename
  $filename = time() . '_' . basename($_FILES['image']['name']);

  $target = "uploads/" . $filename;

  // DEBUG (IMPORTANT)
  if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
    echo "UPLOAD SUCCESS<br>";
    echo "Saved to: " . $target;
  } else {
    echo "UPLOAD FAILED";
    print_r($_FILES); // show error
    exit;
  }
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $id ? "Edit Game" : "Add Game" ?></title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<div class="header">
  <div class="logo">🎮 GimList</div>
</div>

<div class="container">
  <h2><?= $id ? "✏️ Edit Game" : "➕ Add Game" ?></h2>

  <form class="form-box" method="POST" action="game_action.php" enctype="multipart/form-data">

    <!-- ID -->
    <input type="hidden" name="id" value="<?= $id ?>">

    <!-- TITLE -->
    <input type="text" name="title" 
           value="<?= $data['title'] ?? '' ?>" 
           placeholder="Title" required>

    <!-- DEV -->
    <input type="text" name="developer" 
           value="<?= $data['developer'] ?? '' ?>" 
           placeholder="Developer">

    <!-- GENRE -->
    <input type="text" name="genre" 
           value="<?= $data['genre'] ?? '' ?>" 
           placeholder="Genre">

    <!-- YEAR -->
    <input type="number" name="year" 
           value="<?= $data['release_year'] ?? '' ?>" 
           placeholder="Year">

    <!-- CATEGORY -->
    <select name="category_id" required>
      <option value="">Select Category</option>

      <?php
      $c = $conn->query("SELECT * FROM categories");

      while($row = $c->fetch_assoc()):
      ?>
        <option value="<?= $row['id'] ?>"
          <?= (isset($data) && $data['category_id'] == $row['id']) ? 'selected' : '' ?>>
          <?= $row['name'] ?>
        </option>
      <?php endwhile; ?>
    </select>

    <!-- CURRENT IMAGE -->
    <?php if($id && !empty($data['image'])): ?>
      <div style="margin:10px 0;">
        <p style="font-size:14px;color:#94a3b8;">Current Image:</p>

        <img src="/uploads/?= htmlspecialchars($data['image']) ?>" 
             style="width:100%;max-width:200px;border-radius:10px;">
      </div>
    <?php endif; ?>

    <!-- UPLOAD -->
    <input type="file" name="image" id="imgInput"
           accept=".jpg,.jpeg,.png,.webp"
           <?= $id ? '' : 'required' ?>>

    <!-- PREVIEW -->
    <img id="preview"
         style="margin-top:10px;max-width:200px;border-radius:10px;display:none;">

    <button class="btn"><?= $id ? "Update" : "Submit" ?></button>

  </form>
</div>

<!-- PREVIEW SCRIPT -->
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