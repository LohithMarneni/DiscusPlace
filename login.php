<?php
    $showpasserror=false;
    // $showexisterror=false;
  if($_SERVER["REQUEST_METHOD"]=="POST"){
      include "components/_dbconnect.php";
    $username=$_POST["name"];
    $password=$_POST["password"];
    $exist=false;
      // $sql="SELECT * FROM user WHERE name='$username' and password='$password'";
      $sql="SELECT * FROM signups WHERE username='$username'";
      $result=mysqli_query($conn,$sql);
      if($result){
        $rows=mysqli_num_rows($result);
      if($rows==1){
        $row=mysqli_fetch_assoc($result);
          if(password_verify($password,$row["password_hash"])){
            setcookie("login","1",time()+3600,"index.php");
            session_start();
            $_SESSION["loggedin"]=true;
            $_SESSION["username"]=$username;
            header("location:index.php");
          }
          else{
            $showpasserror="Invalid Credentials";
          }
      }
    else{
      $showpasserror="Invalid Credentials";
    }
      }
      else {
        // Handle SQL error
        echo "Error: " . mysqli_error($conn);
    }

    if($showpasserror){
        setcookie("showpasserror",$showpasserror,time()+3600,"index.php");
      }
    }
    header("location:index.php");
?>