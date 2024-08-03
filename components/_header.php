<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true)
{
  $loggedin = true;
  $username = $_SESSION["username"]; // Get the username
}
else {
  $loggedin = false;
}

echo '<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
<div class="container-fluid">
  <a class="navbar-brand" href="/php projects/discusplace project">DiscusPlace</a>
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
      <li class="nav-item">
        <a class="nav-link active" aria-current="page" href="/php projects/discusplace project">Home</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="about.php">About</a>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          Categories
        </a>
        <ul class="dropdown-menu">
          ';
          // <li><a class="dropdown-item" href="#">Action</a></li>
          // <li><a class="dropdown-item" href="#">Another action</a></li>
          // <a href="threadlist.php?catid='.$catid.'" class="text-decoration-none">'.$catname.'</a></h5>
        $getcat="select * from `category`";
        $result=mysqli_query($conn,$getcat);
        $numrows=mysqli_num_rows($result);
        if($numrows>0){
          while($row=mysqli_fetch_assoc($result)){
            $catid=$row["category_id"];
            $catname=$row["category_name"];
            echo '<li><a class="dropdown-item" href="threadlist.php?catid='.$catid.'">'.$catname.'</a></li> ';
          }
        }
        else{
          echo '<li><a class="dropdown-item" href="#">No Categories</a></li>';

        }
        echo '</ul>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="contact.php">Contact Us</a>
      </li>
    </ul>
    <form class="d-flex" role="search">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
      <button class="btn btn-success" type="submit">Search</button>
    </form>
    <div class="mx-2" >';

    // Check if user is logged in
    if(!$loggedin) {
        echo '<button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#loginModal">Login</button>
        <button class="btn btn-outline-success ml-2" data-bs-toggle="modal" data-bs-target="#signupModal">SignUp</button>';
    } else {
        // Display user icon along with username in dropdown
        echo '<div class="dropdown">
                <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                        <path fill="#000000" d="M12,2C15.86,2 19,5.13 19,9C19,12.87 15.87,16 12,16C8.13,16 5,12.87 5,9C5,5.13 8.13,2 12,2M12,18C16.42,18 20,20.74 20,22H4C4,20.74 7.58,18 12,18Z" />
                    </svg>
                    <span class="user-icon">' . $username . '</span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                    <li><a class="dropdown-item" href="#">Profile</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="confirmLogout()">Logout</a></li>
                </ul>
              </div>';
    }
        
echo '</div>
  </div>
</div>
</nav>';

// Include modals for login and signup
include 'components/_loginmodal.php';
include 'components/_signupmodal.php';
?>
