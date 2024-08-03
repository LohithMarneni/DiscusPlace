<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DiscusPlace - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-9IM4g4VvLhQOVD3wOGvYe8vwmjjbKm7GNf7kaW6IheWQrM15S7n3X51/5aTT0OJYsSYZeXRnMk8jpRZxmk8uzw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="threadlist.css">
    <style>
        #ques {
            min-height: 15rem;
        }
    </style>
</head>

<body>

    <?php
    ob_start();// Add session_start() to ensure session is available
    include "components/_dbconnect.php";
    include 'components/_header.php';
    ?>

    <?php
    $threadid = $_GET["threadid"];
    $getsql = "SELECT * FROM `thread` WHERE thread_id= $threadid;";
    $result = mysqli_query($conn, $getsql);
    while ($row = mysqli_fetch_assoc($result)) {
        $title = $row["thread_title"];
        $desc = $row["thread_desc"];
        $threadcatid = $row["thread_cat_id"];
        $threaduserid = $row["thread_user"];
    }
    ?>

    <?php
    $showalert = false;
    $method = $_SERVER["REQUEST_METHOD"];
    if ($method == "POST") {
        $comment = $_POST["comment"];
        if (isset($_SESSION["username"])) {
            $username = $_SESSION["username"];
            $sql = "INSERT INTO `comment` (`comment_content`, `thread_id`, `comment_by`) VALUES ('$comment', '$threadid', '$username');";
            $result = mysqli_query($conn, $sql);
            $showalert = true;
            if ($showalert) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success! </strong> Your comment has been added.
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';
            }
        } else {
            echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> You need to login first to add a comment on this question!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
        }
    }
    ?>

    <!-- category container starts here -->
    <div class="container my-4 ">
        <div class="jumbotron ">
            <h1 class="display-4"><?php echo "Query: " . $title . ""; ?> </h1>
            <p class="lead"><?php echo $desc; ?></p>
            <?php
            $getcount = "SELECT COUNT(comment_id) as commentcount FROM comment WHERE thread_id='$threadid'";
            $countresult = mysqli_query($conn, $getcount);
            $rowdata = mysqli_fetch_assoc($countresult);
            $commentcount = $rowdata["commentcount"];
            if ($commentcount == 0) {
                echo ' <p class="card-text"> No Comments till now!</p> ';
            } else {
                echo ' <p class="card-text">' . $commentcount . ' Comments till now!</p>';
            }
            ?>
            <hr class="my-4">
            <p>Be civil. Don't post anything that a reasonable person would consider offensive, abusive, or hate speech.
                Keep it clean. Don't post anything obscene or sexually explicit.
                Respect each other. Don't harass or grief anyone, impersonate people, or expose their private
                information.
                Respect our forum.</p>
            <p>
                Posted by: <b>Lohith Marneni</b>
            </p>
        </div>
    </div>
    <div class="container mb-3" id="addquery">
        <h2 class="py-2">Post a Comment</h2>
        <form action=<?php echo $_SERVER["REQUEST_URI"] ?> method="POST">
            <div class="mb-3">
                <label for="comment" class="form-label">Type your comment</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Post Comment</button>
        </form>
    </div>

    <div class="container" id="ques">
        <h2 class="py-2">Discussions</h2>
        <?php
        $threadid = $_GET["threadid"];
        $getsql = "SELECT * FROM `comment` WHERE thread_id=$threadid;";
        $result = mysqli_query($conn, $getsql);
        $noresult = true;
        while ($row = mysqli_fetch_assoc($result)) {
            $noresult = false;
            $id = $row["comment_id"];
            $content = $row["comment_content"];
            $time = $row["tstamp"];
            $desired_time_format = date("h:iA", strtotime($time)); // 12-hour time format with AM/PM
            $desired_date_format = date("d-m-Y", strtotime($time));
            $posted_by = $row["comment_by"];
            $likecount = $row["likes"];
            $unlikecount = $row["unlikes"];

            // Check if user has already liked or unliked the comment
            $liked = isset($_SESSION['liked_comments']) && in_array($id, $_SESSION['liked_comments']);
            $unliked = isset($_SESSION['unliked_comments']) && in_array($id, $_SESSION['unliked_comments']);
            
            echo '<div class="media my-3">
                <img class="align-self-start mr-3" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5-cjuBmhKFlC73IgeAvbnkDcC3N80Qrid6xLeM71q1Q&s" width="64" alt="Generic placeholder image">
                <div class="media-body">
                    <p class="my-0"><b>' . $posted_by . '</b> <small>' . $desired_time_format . ' ' . $desired_date_format . '</small></p>
                    ' . $content . '
                    <div class="mt-2">
                        <button type="button" class="btn btn-sm btn-outline-primary like-btn" data-id="' . $id . '" '.($liked ? 'disabled' : '').'>&#128077;</button> <!-- Thumbs up button -->
                        <span class="like-count"><sub>' . $likecount . '</sub></span> <!-- Like count placeholder -->
                        <button type="button" class="btn btn-sm btn-outline-secondary unlike-btn" data-id="' . $id . '" '.($unliked ? 'disabled' : '').'>&#128078;</button> <!-- Thumbs down button -->
                        <span class="unlike-count"><sub>' . $unlikecount . '</sub></span> <!-- Unlike count placeholder -->
                    </div>
                </div>
            </div>';
        }
        if ($noresult) {
            echo '<div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <p class="display-4">No Comments Found</p>
                    <p class="lead"><a href="#addquery" class="text-decoration-none">Be the First Person to answer the Query!</a></p>
                </div>
            </div>';
        }
        ?>
    </div>
    <?php
    include 'components/_footer.php';
    ?>

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to logout?")) {
                window.location.href = "logout.php";
            }
        }

        var loggedIn = <?php echo isset($_SESSION['username']) ? 'true' : 'false'; ?>;

        var likeButtons = document.querySelectorAll(".like-btn");
        likeButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                if (!loggedIn) {
                    alert("You need to log in first to like a comment.");
                    return;
                }
                var commentId = this.getAttribute("data-id");
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText == "success") {
                            button.disabled = true;
                            var likeCountElement = button.nextElementSibling.querySelector("sub");
                            var likeCount = parseInt(likeCountElement.innerText);
                            likeCountElement.innerText = likeCount + 1;
                        }
                    }
                };
                xhr.open("GET", "update_likes.php?comment_id=" + commentId, true);
                xhr.send();
            });
        });

        var unlikeButtons = document.querySelectorAll(".unlike-btn");
        unlikeButtons.forEach(function(button) {
            button.addEventListener("click", function() {
                if (!loggedIn) {
                    alert("You need to log in first to unlike a comment.");
                    return;
                }
                var commentId = this.getAttribute("data-id");
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText == "success") {
                            button.disabled = true;
                            var unlikeCountElement = button.nextElementSibling.querySelector("sub");
                            var unlikeCount = parseInt(unlikeCountElement.innerText);
                            unlikeCountElement.innerText = unlikeCount + 1;
                        }
                    }
                };
                xhr.open("GET", "update_unlikes.php?comment_id=" + commentId, true);
                xhr.send();
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
