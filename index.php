<?php 
session_start();
include 'config.php';

$games = mysqli_query($conn,"
  SELECT games.*, users.name AS publisher
  FROM games
  LEFT JOIN users ON games.user_id = users.id
  ORDER BY games.id DESC
  LIMIT 10
");

$merch = mysqli_query($conn, "SELECT * FROM merch ORDER BY id DESC LIMIT 6");
?>

<!DOCTYPE html>
<html>
<head>
<title>GimList</title>
<link rel="stylesheet" href="assets/style.css">

<style>
/* SLIDER */
.slider {
  overflow: hidden;
  width: 100%;
}

.slider-track {
  display: flex;
  gap: 20px;
  transition: transform 0.6s ease;
}

.slide {
  min-width: calc(100% / 5 - 16px);
}
</style>

</head>

<body>

<!-- NAVBAR -->
<div class="header">
  <div class="logo">🎮 GimList</div>

  <nav class="nav-center">
    <a href="games.php">Games</a>
    <a href="merch.php">Merch</a>
  </nav>

  <div class="nav-right">

    <?php if(isset($_SESSION['user'])) { ?>
      
      <span style="color:#94a3b8;">
        👋 <?= $_SESSION['user']['name']; ?>
      </span>

      <a href="logout.php" class="btn-outline">Logout</a>

    <?php } else { ?>

      <a href="login.php" class="btn-outline">Login</a>

    <?php } ?>

    <div class="dropdown" id="addMenu">
      <button class="btn" onclick="toggleDropdown()">+ Add ▾</button>
      <div class="dropdown-menu">
        <a href="game_form.php">🎮 Add Game</a>
        <a href="merch_form.php">🛍 Add Merch</a>
      </div>
    </div>

  </div>
</div>

<!-- HERO -->
<div class="hero">
  <div class="hero-text">
    <h1>Discover Indonesian Games</h1>
    <p>Explore local creativity 🎮</p>
    <a href="#games" class="btn">Explore</a>
    <a href="#merch" class="btn">Merch</a>
  </div>

  <div class="hero-img">
    <img src="uploads/Hero.webp">
  </div>
</div>

<!-- GAMES -->
<div class="container section" id="games">
  <div class="page-header">
    <h2>🔥 Games</h2>
    <p>Top Indonesian games</p>
  </div>

  <div class="slider">
    <div class="slider-track">

      <?php while($g = mysqli_fetch_assoc($games)) { ?>
        <div class="slide">
          <div class="card">

          <?php if(!empty($g['image'])): ?>
            <img src="uploads/<?= htmlspecialchars($g['image']); ?>">
            <?php else: ?>
              <img src="uploads/default.jpg">
              <?php endif; ?>

            <h3><?= htmlspecialchars($g['title']); ?></h3>
            <p><?= htmlspecialchars($g['genre']); ?></p>

            <p style="color:#94a3b8;font-size:13px;">
              👤 <?= htmlspecialchars($g['publisher']); ?>
            </p>

            <a href="game_detail.php?id=<?= $g['id']; ?>" class="btn">View</a>
          </div>
        </div>
      <?php } ?>

    </div>
  </div>
</div>

<!-- MERCH -->
<div class="container section" id="merch">
  <div class="page-header">
    <h2>🛍 Merchandise</h2>
  </div>

  <div class="grid">
    <?php while($m = mysqli_fetch_assoc($merch)) { ?>
      <div class="card">
        <img src="uploads/<?php echo $m['image']; ?>">
        <h3><?php echo $m['name']; ?></h3>
        <p>Rp <?php echo number_format($m['price']); ?></p>
      </div>
    <?php } ?>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {

  let index = 0;
  const track = document.querySelector(".slider-track");
  const slides = document.querySelectorAll(".slide");
  const slider = document.querySelector(".slider");

  if (!track || slides.length === 0) return;

  let interval;

  function moveSlide() {
    index++;

    if (index > slides.length - 5) {
      index = 0;
    }

    const slideWidth = slides[0].offsetWidth + 20;
    track.style.transform = `translateX(-${index * slideWidth}px)`;
  }


  interval = setInterval(moveSlide, 3000);

  // pause on hover
  slider.addEventListener("mouseenter", () => {
    clearInterval(interval);
  });

  slider.addEventListener("mouseleave", () => {
    interval = setInterval(moveSlide, 3000);
  });

});
function toggleDropdown(){
  document.getElementById("addMenu").classList.toggle("active");
}

document.addEventListener("click", function(e){
  const menu = document.getElementById("addMenu");
  if(!menu.contains(e.target)){
    menu.classList.remove("active");
  }
});
</script>

</body>
</html>