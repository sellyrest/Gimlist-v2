<?php
session_start();
include 'config.php';

$id = $_GET['id'];

/* GAME + PUBLISHER */
$res = mysqli_query($conn,"
  SELECT games.*, users.name AS publisher
  FROM games
  LEFT JOIN users ON games.user_id = users.id
  WHERE games.id=$id
");
$g = mysqli_fetch_assoc($res);

/* LIKE COUNT */
$likes = mysqli_query($conn,"SELECT COUNT(*) as total FROM likes WHERE game_id=$id");
$likeData = mysqli_fetch_assoc($likes);

/* RATING */
$ratingData = mysqli_query($conn,"SELECT AVG(rating) as avg FROM ratings WHERE game_id=$id");
$avgRating = mysqli_fetch_assoc($ratingData)['avg'];

/* CHECK USER LIKE */
$userLiked = false;
if(isset($_SESSION['user'])){
  $uid = $_SESSION['user']['id'];
  $check = mysqli_query($conn,"SELECT * FROM likes WHERE user_id=$uid AND game_id=$id");
  $userLiked = mysqli_num_rows($check) > 0;
}
?>

<!DOCTYPE html>
<html>
<head>
<title><?= $g['title']; ?> - GimList</title>
<link rel="stylesheet" href="assets/style.css">
</head>

<body>

<!-- NAVBAR -->
<div class="header">
  <div class="logo">🎮 GimList</div>

  <nav class="nav-center">
    <a href="index.php">Home</a>
    <a href="games.php">Games</a>
    <a href="merch.php">Merch</a>
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

  <div class="card" style="max-width:600px; margin:auto;">

    <img src="uploads/<?= $g['image']; ?>">

    <h2><?= $g['title']; ?></h2>

    <p><b>Genre:</b> <?= $g['genre']; ?></p>
    <p><b>Developer:</b> <?= $g['developer']; ?></p>
    <p><b>Publisher:</b> <?= $g['publisher'] ?? 'Unknown'; ?></p>

    <button id="likeBtn" 
      data-id="<?= $id ?>" 
      class="btn <?= $userLiked ? 'liked' : '' ?>">
      ❤️ <?= $likeData['total']; ?>
    </button>

    <p style="margin-top:10px;">
      ⭐ Rating: <?= $avgRating ? round($avgRating,1) : 'No rating yet'; ?>
    </p>

    <?php if(isset($_SESSION['user'])) { ?>
      <select id="ratingSelect">
        <option value="">Rate this game</option>
        <option value="1">⭐ 1</option>
        <option value="2">⭐⭐ 2</option>
        <option value="3">⭐⭐⭐ 3</option>
        <option value="4">⭐⭐⭐⭐ 4</option>
        <option value="5">⭐⭐⭐⭐⭐ 5</option>
      </select>
    <?php } ?>

  </div>

  <div style="max-width:600px; margin:30px auto;">

    <h3>💬 Comments</h3>

    <?php if(isset($_SESSION['user'])) { ?>
      <form id="commentForm">
        <textarea name="comment" placeholder="Write your comment..." required></textarea>
        <input type="hidden" name="game_id" value="<?= $id ?>">
        <button class="btn">Send</button>
      </form>
    <?php } else { ?>
      <p><a href="login.php">Login</a> to comment</p>
    <?php } ?>

    <?php
    $comments = mysqli_query($conn,"
      SELECT comments.*, users.name 
      FROM comments 
      JOIN users ON comments.user_id = users.id
      WHERE game_id=$id 
      ORDER BY comments.id DESC
    ");

    while($c = mysqli_fetch_assoc($comments)):
    ?>

      <div class="comment">
        <b><?= $c['name']; ?></b>
        <p><?= $c['comment']; ?></p>
      </div>

    <?php endwhile; ?>

  </div>

</div>

<!-- JS -->
<script>

document.getElementById("likeBtn")?.addEventListener("click", function(){
  fetch("like.php", {
    method:"POST",
    headers:{"Content-Type":"application/x-www-form-urlencoded"},
    body:"game_id="+this.dataset.id
  })
  .then(res=>res.text())
  .then(res=>{
    if(res==="login"){
      alert("Login first");
      return;
    }
    location.reload();
  });
});

document.getElementById("commentForm")?.addEventListener("submit", function(e){
  e.preventDefault();
  const data = new FormData(this);

  fetch("comment.php", {method:"POST", body:data})
  .then(res=>res.text())
  .then(()=>location.reload());
});

document.getElementById("ratingSelect")?.addEventListener("change", function(){
  fetch("rating.php", {
    method:"POST",
    headers:{"Content-Type":"application/x-www-form-urlencoded"},
    body:"game_id=<?= $id ?>&rating="+this.value
  })
  .then(()=>location.reload());
});

</script>

</body>
</html>