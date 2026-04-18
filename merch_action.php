<?php 
include 'config.php';

/* DELETE */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM merch WHERE id=$id");
    header("Location: merch.php");
    exit;
}

/* CREATE / UPDATE */
if ($_POST) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $game_id = $_POST['game_id'];
    $category_id = $_POST['category_id'];

    $img = null;

    // HANDLE IMAGE UPLOAD
    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);
    }

    // UPDATE
    if ($id) {
        if ($img) {
            $conn->query("UPDATE merch SET 
                name='$name',
                price='$price',
                game_id='$game_id',
                category_id='$category_id',
                image='$img'
                WHERE id=$id");
        } else {
            $conn->query("UPDATE merch SET 
                name='$name',
                price='$price',
                game_id='$game_id',
                category_id='$category_id'
                WHERE id=$id");
        }
    } 
    // CREATE
    else {
        $conn->query("INSERT INTO merch (name, price, game_id, category_id, image)
            VALUES ('$name', '$price', '$game_id', '$category_id', '$img')");
    }

    header("Location: merch.php");
    exit;
}
?>