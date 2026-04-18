<?php 
include 'config.php';

/* DELETE */
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $conn->query("DELETE FROM games WHERE id=$id");
    header("Location: games.php");
    exit;
}

/* CREATE / UPDATE */
if ($_POST) {
    $id = $_POST['id'] ?? null;
    $title = $_POST['title'] ?? '';
    $dev = $_POST['developer'] ?? '';
    $genre = $_POST['genre'] ?? '';
    $year = isset($_POST['year']) ? (int)$_POST['year'] : 0;

    $img = 'default.jpg';

    // HANDLE IMAGE UPLOAD
    if (!empty($_FILES['image']['name'])) {
        $img = $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], "uploads/" . $img);
    }

    // UPDATE
    if ($id) {
        if ($img !== 'default.jpg') {
            $conn->query("UPDATE games SET 
                title='$title',
                developer='$dev',
                genre='$genre',
                release_year='$year',
                image='$img'
                WHERE id=$id");
        } else {
            $conn->query("UPDATE games SET 
                title='$title',
                developer='$dev',
                genre='$genre',
                release_year='$year'
                WHERE id=$id");
        }
    } 
    // CREATE
    else {
        $conn->query("INSERT INTO games (title, developer, genre, release_year, image)
            VALUES ('$title', '$dev', '$genre', '$year', '$img')");
    }

    header("Location: games.php");
    exit;
}
?>