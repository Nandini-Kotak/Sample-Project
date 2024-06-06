<?php

include "config.php";
session_start();

if(isset($_SESSION['uid'])){
    setcookie('username',"");

    if(session_destroy()){
        header("Location:login.php");
    }
}