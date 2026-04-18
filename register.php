<?php 
include 'config.php';

$msg = "";
$error = "";

if(isset($_POST['register'])){

  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = $_POST['password'];
  $confirm = $_POST['confirm'];

  // VALIDATION
  if($password !== $confirm){
    $error = "Passwords do not match!";
  } else {

    // CHECK EMAIL EXISTS
    $check = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
    if(mysqli_num_rows($check) > 0){
      $error = "Email already registered!";
    } else {

      $hash = password_hash($password, PASSWORD_DEFAULT);

      mysqli_query($conn,"INSERT INTO users(name,email,password) 
      VALUES('$name','$email','$hash')");

      $msg = "Account created! You can login now.";
    }
  }
}
?>
<link rel="stylesheet" href="assets/style.css">

<div class="auth-container">

  <!-- LEFT -->
  <div class="auth-left">
    <div class="floating-icons">
      <span>🎮</span><span>🕹️</span><span>👾</span><span>🎯</span><span>💻</span>
    </div>

    <h1>Join GimList</h1>
    <p>Create account and discover amazing Indonesian games</p>
  </div>

  <!-- RIGHT -->
  <div class="auth-right">
    <form method="POST" class="auth-box">

      <h2>Register</h2>

      <?php if($error): ?>
        <div class="alert alert-error"><?= $error ?></div>
      <?php endif; ?>

      <?php if($msg): ?>
        <div class="alert alert-success"><?= $msg ?></div>
      <?php endif; ?>

      <input name="name" type="text" placeholder="Username" required>

 
      <input name="email" type="email" placeholder="Email" required>

   
      <input name="password" type="password" placeholder="Password" required>


      <input name="confirm" type="password" placeholder="Confirm Password" required>

      <button name="register">Create Account</button>

      <a href="login.php" class="auth-link">Already have an account? Login</a>

    </form>
  </div>

</div>