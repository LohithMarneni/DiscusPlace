<?php
session_start();
include 'components/_dbconnect.php';

if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $comment_id = $_GET['comment_id'];

    if (!isset($_SESSION['unliked_comments'])) {
        $_SESSION['unliked_comments'] = array();
    }

    if (!in_array($comment_id, $_SESSION['unliked_comments'])) {
        $sql = "UPDATE `comment` SET `unlikes` = `unlikes` + 1 WHERE `comment_id` = $comment_id";
        if (mysqli_query($conn, $sql)) {
            $_SESSION['unliked_comments'][] = $comment_id;
            echo "success";
        } else {
            echo "error";
        }
    } else {
        echo "already unliked";
    }
} else {
    echo "not logged in";
}
?>
