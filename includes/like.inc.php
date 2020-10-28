<?php
require "dbh.inc.php";

if(isset($_POST['like'])) {
    $post = $_POST['post_id'];
    $user = $_POST['user'];
    $like = 1;
    $sql = "INSERT INTO likes (post_id, like_user, like_confirm) VALUES (?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $post, $user, $like);
        mysqli_stmt_execute($stmt);
        header("Location: ../home.php");
    }
}

if(isset($_POST['dislike'])) {
    $post = $_POST['post_id'];
    $user = $_POST['user'];
    $sql = "DELETE FROM likes WHERE post_id=? && like_user=?";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        exit();
    } else {
        mysqli_stmt_bind_param($stmt, "ss", $post, $user);
        mysqli_stmt_execute($stmt);
        header("Location: ../home.php");
    }
}
?>