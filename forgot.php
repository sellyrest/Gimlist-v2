<?php
include 'config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$msg = "";
$error = "";

if(isset($_POST['email'])){

  $email = $_POST['email'];

  $user = mysqli_query($conn,"SELECT * FROM users WHERE email='$email'");

  if(mysqli_num_rows($user) > 0){

    $token = bin2hex(random_bytes(32));
    $expire = date("Y-m-d H:i:s", strtotime("+1 hour"));

    mysqli_query($conn,"UPDATE users 
      SET reset_token='$token', token_expire='$expire' 
      WHERE email='$email'");

    $link = "http://localhost/yourproject/reset.php?token=$token";

    // SEND EMAIL
    $mail = new PHPMailer(true);

    try {
      $mail->isSMTP();
      $mail->Host = 'smtp.gmail.com';
      $mail->SMTPAuth = true;
      $mail->Username = 'YOUR_EMAIL@gmail.com';
      $mail->Password = 'YOUR_APP_PASSWORD';
      $mail->SMTPSecure = 'tls';
      $mail->Port = 587;

      $mail->setFrom('YOUR_EMAIL@gmail.com', 'GimList');
      $mail->addAddress($email);

      $mail->isHTML(true);
      $mail->Subject = 'Reset Password';
      $mail->Body = "
        Click link to reset password:<br>
        <a href='$link'>$link</a>
      ";

      $mail->send();
      $msg = "Reset link sent to your email!";

    } catch (Exception $e) {
      $error = "Failed to send email.";
    }

  } else {
    $error = "Email not found!";
  }
}
?>
<form method="POST" class="auth-box">

<h2>Reset Password</h2>

<?php if($error): ?>
  <div class="alert alert-error"><?= $error ?></div>
<?php endif; ?>

<?php if($msg): ?>
  <div class="alert alert-success"><?= $msg ?></div>
<?php endif; ?>

<input name="email" type="email" placeholder="Email" required>

<button>Send Reset Link</button>

<a href="login.php" class="auth-link">Back to login</a>

</form>
<?php
include 'config.php';

$token = $_GET['token'] ?? null;

$user = mysqli_query($conn,"SELECT * FROM users 
WHERE reset_token='$token' 
AND token_expire > NOW()");

if(mysqli_num_rows($user) == 0){
  die("Invalid or expired token");
}

if(isset($_POST['password'])){

  $newPass = password_hash($_POST['password'], PASSWORD_DEFAULT);

  mysqli_query($conn,"UPDATE users 
  SET password='$newPass', reset_token=NULL, token_expire=NULL 
  WHERE reset_token='$token'");

  echo "<script>alert('Password updated!');location='login.php';</script>";
}
?>

<form method="POST">
  <input type="password" name="password" placeholder="New Password" required>
  <button>Reset Password</button>
</form>