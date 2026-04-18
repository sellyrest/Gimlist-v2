<link rel="stylesheet" href="assets/style.css">

<div class="header">
  <div class="logo">🎮 GimList</div>
</div>

<div class="container">
  <h2>Add Game</h2>

  <form class="form-box" method="POST" action="game_action.php" enctype="multipart/form-data">
  <input type="text" name="title" placeholder="Title" required>
  <input type="text" name="developer" placeholder="Developer">
  <input type="text" name="genre" placeholder="Genre">
  <input type="number" name="year" placeholder="Year">

  <input type="file" name="image" accept="image/*" required>

  <button class="btn">Submit</button>
</form>
</div>