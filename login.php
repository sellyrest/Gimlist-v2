<?php 
include 'config.php';

$error = "";

if(isset($_POST['login'])){
  $email = $_POST['email'];
  $password = $_POST['password'];

  $res = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");
  $user = mysqli_fetch_assoc($res);

  if($user && password_verify($password,$user['password'])){
    $_SESSION['user']=$user;
    header("Location:index.php");
    exit;
  } else {
    $error = "Invalid email or password";
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <title>Login - GimList</title>
  <link rel="stylesheet" href="assets/style.css">

  <style>
  /* 🎮 FLOATING GAME ICONS */
  .floating-icons span {
    position:absolute;
    font-size:28px;
    animation:float 8s infinite ease-in-out;
    opacity:0.2;
  }

  .floating-icons span:nth-child(1){ top:20%; left:10%; animation-delay:0s;}
  .floating-icons span:nth-child(2){ top:40%; left:30%; animation-delay:2s;}
  .floating-icons span:nth-child(3){ top:70%; left:20%; animation-delay:4s;}
  .floating-icons span:nth-child(4){ top:60%; left:5%; animation-delay:1s;}
  .floating-icons span:nth-child(5){ top:30%; left:40%; animation-delay:3s;}

  @keyframes float {
    0% { transform:translateY(0px); }
    50% { transform:translateY(-20px); }
    100% { transform:translateY(0px); }
  }
  </style>
</head>

<body>

<div class="auth-container">

  <!-- LEFT SIDE -->
  <div class="auth-left">

    <div class="floating-icons">
      <span>🎮</span>
      <span>🕹️</span>
      <span>👾</span>
      <span>🎯</span>
      <span>💾</span>
    </div>

    <h1>Welcome Back</h1>
    <p>Login to continue exploring Indonesian games 🎮</p>
  </div>

  <!-- RIGHT SIDE -->
  <div class="auth-right">
    <form method="POST" class="auth-box">

      <h2>Login</h2>

      <?php if($error): ?>
        <div class="alert alert-error"><?php echo $error; ?></div>
      <?php endif; ?>

      <input name="email" type="email" placeholder="Email" required>
      <input name="password" type="password" placeholder="Password" required>

      <button name="login">Login</button>

      <a href="forgot.php" class="auth-link">Forgot password?</a>
      <a href="register.php" class="auth-link">Create account</a>

    </form>
  </div>

</div>

</body>
</html>