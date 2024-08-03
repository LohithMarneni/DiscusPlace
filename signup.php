<?php
$showerror=false;
if($_SERVER["REQUEST_METHOD"]=="POST"){
  include "components/_dbconnect.php";
  $username=$_POST["name"];
  $email=$_POST["email"];
  $password=$_POST["password"];
  $cpassword=$_POST["cpassword"];
  $existsql="select * from signups where username='$username';";
  $resultexist=mysqli_query($conn,$existsql);
  $numrows=mysqli_num_rows($resultexist);
  if($numrows> 0){
    $showerror="Username already existed try another one!!";
  }
  else{
    if(($password==$cpassword)){
      $hash=password_hash($password,PASSWORD_DEFAULT);
      $sql="INSERT INTO `signups` (`username`,`email`, `password_hash`) VALUES ('$username', '$email','$hash');";
      $result=mysqli_query($conn,$sql);
      if($result){
        setcookie("showalert","1",time()+3600,"index.php");
      }
    }
    else{
        $showerror="password doesn't match";
    }
  }
  if($showerror){
    setcookie("showerror",$showerror,time()+3600,"index.php");
  }
}


// echo "cookie is set";
header("location:index.php");
  ?>