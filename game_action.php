<?php
session_start();
include 'config.php';

/* MUST LOGIN */
if(!isset($_SESSION['user'])){
  echo "<script>alert('Login required');location='login.php';</script>";
  exit;
}

/* ADD / UPDATE */
if(isset($_POST['title'])){

  $id    = $_POST['id'] ?? null;
  $title = $_POST['title'];
  $dev   = $_POST['developer'];
  $genre = $_POST['genre'];
  $year  = $_POST['year'];
  $cat   = $_POST['category_id'];
  $user_id = $_SESSION['user']['id'];

  $newName = null;

  /* FILE UPLOAD */
  if(!empty($_FILES['image']['name'])){

    $file = $_FILES['image'];
    $name = $file['name'];
    $tmp  = $file['tmp_name'];
    $size = $file['size'];
    $error= $file['error'];

    $maxSize = 2 * 1024 * 1024;
    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));

    if($error !== 0){
      echo "<script>alert('Upload failed');history.back();</script>";
      exit;
    }

    if($size > $maxSize){
      echo "<script>alert('Image too large (max 2MB)');history.back();</script>";
      exit;
    }

    if(!in_array($ext, $allowed)){
      echo "<script>alert('Invalid file type');history.back();</script>";
      exit;
    }

    $newName = time()."_".uniqid().".".$ext;
    move_uploaded_file($tmp, "./uploads/".$newName);
  }

  /* ===== UPDATE MODE ===== */
  if($id){

    // check ownership
    $check = mysqli_query($conn, "SELECT * FROM games WHERE id='$id' AND user_id='$user_id'");
    if(mysqli_num_rows($check) == 0){
      echo "<script>alert('Unauthorized');location='games.php';</script>";
      exit;
    }

    if($newName){
      mysqli_query($conn, "
        UPDATE games SET
        title='$title',
        developer='$dev',
        genre='$genre',
        release_year='$year',
        category_id='$cat',
        image='$newName'
        WHERE id='$id'
      ");
    } else {
      mysqli_query($conn, "
        UPDATE games SET
        title='$title',
        developer='$dev',
        genre='$genre',
        release_year='$year',
        category_id='$cat'
        WHERE id='$id'
      ");
    }

  } else {

    /* ===== INSERT ONLY ONCE ===== */
    mysqli_query($conn, "
      INSERT INTO games(title, developer, genre, release_year, image, user_id, category_id)
      VALUES('$title','$dev','$genre','$year','$newName','$user_id','$cat')
    ");
  }

  header("Location: games.php");
  exit;
}

/* DELETE */
if(isset($_GET['delete'])){
  $id = $_GET['delete'];
  $user_id = $_SESSION['user']['id'];

  $check = mysqli_query($conn, "SELECT * FROM games WHERE id='$id' AND user_id='$user_id'");

  if(mysqli_num_rows($check) > 0){
    mysqli_query($conn, "DELETE FROM games WHERE id='$id'");
  }

  header("Location: games.php");
  exit;
}
?>