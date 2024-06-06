<?php
include "config.php";
session_start();

if(isset($_POST['login_btn'])){
    $email=mysqli_real_escape_string($conn,$_POST['lgemail']);
    $password=mysqli_real_escape_string($conn,md5($_POST['lgpassword']));

    $sqllogin="Select * from users where email='".$email."' and password= '".$password."' and status='active'";
    $resultlogin=mysqli_query($conn,$sqllogin);

    if(mysqli_num_rows($resultlogin)>0){
        
        if($rowLogin=mysqli_fetch_assoc($resultlogin)){
            $_SESSION['uid']= $rowLogin['id'];
            $name=$rowLogin['firstname'];
    
            setcookie("username",$name);

            $last_login = date('Y-m-d H:i:s');
            $sql_update = "UPDATE users SET last_login='$last_login' WHERE id=".$rowLogin['id'];
            mysqli_query($conn, $sql_update);
            header("Location:home.php");

          
    
        }else{
             echo "<script>alert('Oops somethng went wrong!');</script>";
             header("Loaction:login.php");
        }
        
    }else{
        echo "<script>alert('Invalid Email or Password');</script>";
        header("Loaction:login.php");
    }
}

