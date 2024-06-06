<?php
session_start();
include "config.php";

if (isset($_POST['admin_login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    
 
    $admin_query = "SELECT * FROM admins WHERE username='$username' AND password='$password'";
    $result_admin = mysqli_query($conn, $admin_query);
    
    if (mysqli_num_rows($result_admin) > 0) {
        $_SESSION['admin'] = $username;
        header("Location: admin_dashboard.php");
        exit();
    } else {
        echo "<script>alert('Invalid credentials'); window.location.href='admin_login.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>

    
    <section class="bg-primary py-3 py-md-5 py-xl-8" style='height:100vh'>
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-12 col-md-8 col-xl-6">
                <div class="custom-form-width">
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h2 class="h3">Admin Login</h2>
                                    </div>
                                </div>
                            </div> 
                            <form method="post" action="">
                                <div class="mb-3">
                                    <label for="username" class="form-label">Username:</label>
                                    <input type="text" name="username" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label for="password" class="form-label">Password:</label>
                                    <input type="password" name="password" class="form-control" required>
                                </div>
                                <button type="submit" name="admin_login_btn" class="btn btn-primary">Login</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
</html>
