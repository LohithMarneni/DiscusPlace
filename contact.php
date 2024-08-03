<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DiscusPlace - Coding Forums</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
      #but1{
        margin-bottom:1rem;
      }
    </style>
</head>
<body>
  <?php
  include "components/_dbconnect.php";
  include 'components/_header.php';
  ?>
  <?php
if($_SERVER['REQUEST_METHOD']=='POST'){
  $name=$_POST['name'];
  $concern=$_POST['concern'];
  $servername="localhost";
   $sql="insert into `contactus`(`username`,`concern`)
values ('$name','$concern');";
$result=mysqli_query($conn,$sql);
if($result){
  echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!! </strong>your Concern has reached us. We will try our best to solve your concern!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
else{
    // echo "details not entered in database table ----->".mysqli_error($conn);
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!! </strong> We are facing some technical issue, form was not submitted. Sorry for inconvenience!
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>';
}
}
 ?>
 <div class="container my-4" >
<form action="contact.php" method="post">
  <div class="mb-3">
    <h3>Contact us</h3>
    <label for="name" class="form-label">Username</label>
    <input type="text" class="form-control" id="name" aria-describedby="name" name="name">
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Concern</label>
    <textarea name="concern" id="concern" class="form-control" cols="30" rows="5"></textarea>
  </div>
  <button type="submit" class="btn btn-primary mb-10" id="but1">Submit</button>
</form>
</div>
<div class="container-fluid bg-dark text-light fixed-bottom" >
    <p class="text-center py-3 mb-0">&copy; Copyrights DiscusPlace Coding Forum 2024 | All rights reserved</p>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>
</body>

</html>