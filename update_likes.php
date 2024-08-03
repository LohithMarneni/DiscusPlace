<?php
session_start();
include 'components/_dbconnect.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $comment_id = $_GET['comment_id'];

    if (!isset($_SESSION['liked_comments'])) {
        $_SESSION['liked_comments'] = array();
    }

    if (!in_array($comment_id, $_SESSION['liked_comments'])) {
        $sql = "UPDATE `comment` SET `likes` = `likes` + 1 WHERE `comment_id` = $comment_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['liked_comments'][] = $comment_id;
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "already liked";
    }
} else {
    echo "not logged in";
}
?>
