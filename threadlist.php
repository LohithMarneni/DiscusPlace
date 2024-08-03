<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DiscusPlace - Coding Forums</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="threadlist.css">
    <style>
    #ques {
        min-height: 15rem;
    }
    </style>
</head>

<body>

    <?php
  ob_start();
  include "components/_dbconnect.php";
  include 'components/_header.php';
  ?>
    <?php
  $catid=$_GET["catid"];
  $getsql="SELECT * FROM `category` WHERE category_id= $catid;";
  $result=mysqli_query($conn, $getsql);
  while($row=mysqli_fetch_assoc($result)){
    $catname=$row["category_name"];
    $catdesc=$row["category_description"];
  }
  ?>
    <!--/*     <?php
//   if (isset($_COOKIE["showalert"])) {
//     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
//     <strong>Success!</strong> Your account is now created now You can login
//     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//     </div>';
//     setcookie("showalert", "", time() - 3600, "index.php");
//   }
//   if (isset($_COOKIE["showerror"])) {
//     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
//       <strong>Error!</strong> ' . $_COOKIE["showerror"] . '... Failed to create account!! try again
//       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//       </div>';
//     setcookie("showerror", "", time() - 3600, "index.php");
//   }
//   if(isset($_COOKIE["login"])){
//     $username=$_SESSION["username"];
//     echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
//   <strong>Success!</strong> You had succesfully logged in as '.$username.'
//   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
// </div>';
// setcookie("login", "", time() - 3600, "index.php");
//    }
//    if(isset($_COOKIE["showpasserror"])){
//     echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
//   <strong>Error!</strong> '.$_COOKIE["showpasserror"].'! Your Credentials are wrong
//   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
// </div>';
// setcookie("showpasserror", "", time() - 3600, "index.php");
//    }
  ?> */-->
<?php
$showalert=false;
$method=$_SERVER["REQUEST_METHOD"];
if($method=="POST"){
    $th_title=$_POST["problemtitle"];
    $th_desc=$_POST["problemdesc"];
    if(isset($_SESSION["username"])){
        $username=$_SESSION["username"];
        $sql="INSERT INTO `thread` ( `thread_title`, `thread_desc`, `thread_cat_id`, `thread_user`) VALUES ( '$th_title', '$th_desc', '$catid', '$username');";
    $result=mysqli_query($conn, $sql);
    $showalert=true;
    if($showalert){
       echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success! </strong> Your question has added. Please wait till someone responded
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
    }
    }
    else{
                echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
              <strong>Error!</strong> Need to Login first to add a Question!
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
    
}
?>

    <!-- category container starts here -->
    <div class="container my-4 ">
        <div class="jumbotron ">
            <h1 class="display-4">Welcome to <?php
            echo $catname;
            ?> Forums</h1>
            <p class="lead"><?php
            echo $catdesc;
            ?></p>
             <?php
             $getcount="select count(thread_id) as questioncount from thread where thread_cat_id='$catid'";
             $countresult=mysqli_query($conn,$getcount);
             $rowdata=mysqli_fetch_assoc($countresult);
             $questioncount=$rowdata["questioncount"];
             echo "<p class='card-text'>".$questioncount." Questions till now!</p> ";
             ?>
            <hr class="my-4">
            <p>Be civil. Don't post anything that a reasonable person would consider offensive, abusive, or hate speech.
                Keep it clean. Don't post anything obscene or sexually explicit.
                Respect each other. Don't harass or grief anyone, impersonate people, or expose their private
                information.
                Respect our forum.</p>
            <a class="btn btn-success btn-lg" href="#" role="button">Learn more</a>
        </div>
    </div>
    <div class="container mb-3" id="addquery">
    <h2 class="py-2">Start a Discussion</h2>
        <form action=<?PHP echo $_SERVER["REQUEST_URI"]?> method="POST">
            <div class="mb-3">
                <label for="problemtitle" class="form-label">Problem Title</label>
                <input type="text" class="form-control" id="problemtitle" name="problemtitle"
                    aria-describedby="emailHelp">
                <div id="emailHelp" class="form-text">Keep the title as short and crisp as possible.</div>
            </div>
            <div class="mb-3">
                <label for="problemdesc" class="form-label">Problem Description</label>
                <textarea class="form-control" id="problemdesc" name="problemdesc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-success">Add Question</button>
        </form>
    </div>
    <div class="container" id="ques">
        <h2 class="py-2">Browse Questions</h2>
        <?php
  $catid=$_GET["catid"];
  $getsql="SELECT * FROM `thread` WHERE thread_cat_id=$catid;";
  $result=mysqli_query($conn, $getsql);
  $noresult=true;
  while($row=mysqli_fetch_assoc($result)){
    $noresult=false;
    $id= $row["thread_id"];
    $title=$row["thread_title"];
    $desc=$row["thread_desc"];
    $time = $row["tstamp"];
    $asked_by=$row["thread_user"];
    $desired_time_format = date("h:iA", strtotime($time)); // 12-hour time format with AM/PM
    $desired_date_format = date("d-m-Y", strtotime($time));
    $getcount="select count(comment_id) as commentcount from comment where thread_id='$id'";
    $countresult=mysqli_query($conn,$getcount);
    $rowdata=mysqli_fetch_assoc($countresult);
    $commentcount=$rowdata["commentcount"];
    echo '<div class="media my-3">

        <img class="align-self-start mr-3"
            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcS5-cjuBmhKFlC73IgeAvbnkDcC3N80Qrid6xLeM71q1Q&s"
            width="64" alt="Generic placeholder image">
        <div class="media-body">
        <p class=" my-0"><b>'.$asked_by.' </b><small>'.$desired_time_format.'  '.$desired_date_format.'</small></p>
            <h5 class="mt-0"><a href="thread.php?threadid='.$id.'" class="text-dark text-decoration-none">'.$title.'</a></h5>
            '.$desc.'';
    if($commentcount==0){
echo ' <p class="card-text"> No Comments till now!</p> 
</div>
</div>';
}
else{
    echo ' <p class="card-text">'.$commentcount.' Comments till now!</p> 
</div>
</div>';
}
           
}
if($noresult){
    echo '<div class="jumbotron jumbotron-fluid">
    <div class="container">
      <p class="display-4">No Questions Found</p>
      <p class="lead"><a href="#addquery" class="text-decoration-none">Be the First Person to ask Query in this Category!</a></p>
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
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>