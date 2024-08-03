<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DiscusPlace - Coding Forums</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      #ques{
        min-height:15rem;
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
  if (isset($_COOKIE["showalert"])) {
    echo '<div class="alert alert-success alert-dsismissible fade show" role="alert">
    <strong>Success!</strong> Your account is now created now You can login
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>';
    setcookie("showalert", "", time() - 3600, "index.php");
  }
  if (isset($_COOKIE["showerror"])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> ' . $_COOKIE["showerror"] . '... Failed to create account!! try again
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>';
    setcookie("showerror", "", time() - 3600, "index.php");
  }
  if(isset($_COOKIE["login"])){
    $username=$_SESSION["username"];
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> You had succesfully logged in as '.$username.'
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
setcookie("login", "", time() - 3600, "index.php");
   }
   if(isset($_COOKIE["showpasserror"])){
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> '.$_COOKIE["showpasserror"].'! Your Credentials are wrong
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
setcookie("showpasserror", "", time() - 3600, "index.php");
   }
  ?>
  <!-- slider starts here -->
  <div id="carouselExampleIndicators" class="carousel slide">
    <div class="carousel-indicators">
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
        aria-current="true" aria-label="Slide 1"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
        aria-label="Slide 2"></button>
      <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
        aria-label="Slide 3"></button>
    </div>
    <div class="carousel-inner">
      <div class="carousel-item active">
        <img src="https://source.unsplash.com/2200x700/?programming,python" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="https://source.unsplash.com/2200x700/?programming,javascript" class="d-block w-100" alt="...">
      </div>
      <div class="carousel-item">
        <img src="https://source.unsplash.com/2200x700/?3d,blender" class="d-block w-100" alt="...">
      </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
      data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>
  <!-- category container starts here -->
  <div class="container my-4" id="ques">
    <h2 class='text-center my-4'>DiscusPlace - Browse Categories</h2>
    <div class="row">
      <?php
      // <!-- use a for loop to iterate through categories -->
      $sql="SELECT * FROM `category`";
      $result=mysqli_query($conn,$sql);
      while($row=mysqli_fetch_assoc($result)){
        $catid=$row["category_id"];
        $catname=$row["category_name"];
        $catdesc=$row["category_description"];
        $getcount="select count(thread_id) as questioncount from thread where thread_cat_id='$catid'";
        $countresult=mysqli_query($conn,$getcount);
        $rowdata=mysqli_fetch_assoc($countresult);
        $questioncount=$rowdata["questioncount"];
        echo '<div class="col-md-4 my-2">
        <div class="card" style="width: 18rem;">
          <img src="https://source.unsplash.com/500x400/?'.$catname.',coding,programming" class="card-img-top" alt="...">
          <div class="card-body">
            <h5 class="card-title"><a href="threadlist.php?catid='.$catid.'" class="text-decoration-none">'.$catname.'</a></h5>
            <p class="card-text">'.substr($catdesc,0,90).'...</p>
            <p class="card-text">Total Questions:'.$questioncount.' </p> <!-- This line shows the count of questions -->
            <a href="threadlist.php?catid='.$catid.'" class="btn btn-primary">View questions</a>
          </div>
        </div>
      </div>';

      }
      ?>

      

    </div>
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
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>