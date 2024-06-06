<?php
include "config.php";
session_start();

if(!isset($_SESSION['uid'])){
    header("Location: login.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
</head>
<body>
    <p> Welcome
    <?php
    if (isset($_COOKIE['username'])){
        echo  $_COOKIE['username'];
    }
    ?>    

    </p>

    <a href="logout.php">Logout</a>
</body>
</html>