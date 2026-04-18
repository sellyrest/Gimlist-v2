<?php 
session_start();
include 'config.php';

$games = mysqli_query($conn, "SELECT * FROM games ORDER BY id DESC");
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
    <a href="#games">Games</a>
    <a href="#merch">Merch</a>
  </nav>

  <div class="nav-right">
    <a href="game_form.php" class="btn">+ Add</a>
  </div>
</div>

<!-- HERO -->
<div class="hero">
  <div class="hero-text">
    <h1>Discover Indonesian Games</h1>
    <p>Explore local creativity 🎮</p>
    <a href="#games" class="btn">Explore</a>
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
            <img src="uploads/<?php echo $g['image']; ?>">
            <h3><?php echo $g['title']; ?></h3>
            <p><?php echo $g['genre']; ?></p>
            <a href="game_detail.php?id=<?php echo $g['id']; ?>" class="btn">View</a>
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

  // ✅ NOW 3 SECONDS
  interval = setInterval(moveSlide, 3000);

  // pause on hover
  slider.addEventListener("mouseenter", () => {
    clearInterval(interval);
  });

  slider.addEventListener("mouseleave", () => {
    interval = setInterval(moveSlide, 3000);
  });

});
</script>

</body>
</html>