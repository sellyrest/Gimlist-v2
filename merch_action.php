<?php
session_start();
include 'config.php';

/* MUST LOGIN */
if(!isset($_SESSION['user'])){
  echo "<script>alert('Login required');location='login.php';</script>";
  exit;
}

$user_id = $_SESSION['user']['id'];

/* ADD / UPDATE */
if(isset($_POST['name'])){

  $id = $_POST['id'] ?? null;

  $name = $_POST['name'];
  $price = $_POST['price'];
  $game = $_POST['game_id'];
  $cat = $_POST['category_id'];

  $filename = '';

  /* HANDLE IMAGE UPLOAD */
  if(isset($_FILES['image']) && $_FILES['image']['error'] === 0){

    $allowed = ['jpg','jpeg','png','webp'];
    $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

    if(!in_array($ext, $allowed)){
      echo "<script>alert('Only JPG, PNG, WEBP allowed');history.back();</script>";
      exit;
    }

    $safeName = preg_replace("/[^a-zA-Z0-9.]/", "", $_FILES['image']['name']);
    $filename = time() . "_" . $safeName;

    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $filename);
  }

  /* EDIT */
  if($id){

    $id = (int)$id;

    // get old image
    $old = $conn->query("SELECT image FROM merch WHERE id=$id AND user_id=$user_id")->fetch_assoc();

    if(!$old){
      echo "<script>alert('Unauthorized');location='merch.php';</script>";
      exit;
    }

    if($filename){
      // delete old image
      if(!empty($old['image']) && file_exists("/uploads/" . $old['image'])){
        unlink("/uploads/" . $old['image']);
      }

      $conn->query("UPDATE merch SET
        name='$name',
        price='$price',
        game_id='$game',
        category_id='$cat',
        image='$filename'
        WHERE id=$id AND user_id=$user_id
      ");

    } else {
      $conn->query("UPDATE merch SET
        name='$name',
        price='$price',
        game_id='$game',
        category_id='$cat'
        WHERE id=$id AND user_id=$user_id
      ");
    }

  }

  /* ADD */
  else{

    if(!$filename){
      echo "<script>alert('Image required');history.back();</script>";
      exit;
    }

    $conn->query("INSERT INTO merch(name,price,game_id,category_id,image,user_id)
      VALUES('$name','$price','$game','$cat','$filename','$user_id')");
  }

  header("Location: merch.php");
  exit;
}

/* DELETE */
if(isset($_GET['delete'])){
  $id = (int)$_GET['delete'];

  // get image first
  $old = $conn->query("SELECT image FROM merch WHERE id=$id AND user_id=".$_SESSION['user']['id'])->fetch_assoc();

  if($old){
    if(!empty($old['image']) && file_exists("/uploads/" . $old['image'])){
      unlink("/uploads/" . $old['image']);
    }

    $conn->query("DELETE FROM merch WHERE id=$id AND user_id=".$_SESSION['user']['id']);
  }

  header("Location: merch.php");
  exit;
}
?>