<?php 
include 'config.php';
$msg="";

if(isset($_POST['register'])){
  $email=$_POST['email'];
  $pass=password_hash($_POST['password'],PASSWORD_DEFAULT);

  mysqli_query($conn,"INSERT INTO users(email,password) VALUES('$email','$pass')");
  $msg="Account created! You can login now.";
}
?>

<link rel="stylesheet" href="assets/style.css">

<div class="auth-container">

  <div class="auth-left">
    <div class="floating-icons">
      <span>🎮</span><span>🕹️</span><span>👾</span>
    </div>

    <h1>Join GimList</h1>
    <p>Create account and discover amazing Indonesian games</p>
  </div>

  <div class="auth-right">
    <form method="POST" class="auth-box">

      <h2>Register</h2>

      <?php if($msg): ?>
        <div class="alert alert-success"><?php echo $msg; ?></div>
      <?php endif; ?>

      <input name="email" type="email" placeholder="Email" required>
      <input name="password" type="password" placeholder="Password" required>

      <button name="register">Register</button>

      <a href="login.php" class="auth-link">Back to login</a>

    </form>
  </div>

</div>