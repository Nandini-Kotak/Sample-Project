<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/registrations/registration-9/assets/css/registration-9.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                                            <h2 class="h3">Login</h2>
                                            <h3 class="fs-6 fw-normal text-secondary m-0">Enter your email and password to Login</h3>
                                        </div>
                                    </div>
                                </div> 
                                <form id="loginForm" action="login-backend.php" method="post">
                                    <div class="row gy-3 overflow-hidden">
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="text" class="form-control" name="lgemail" id="lgemail" placeholder="name@example.com" required>
                                                <label for="Email" class="form-label">Email</label>
                                            </div>
                                        </div>
                                        
                                        
                                        <div class="col-12">
                                            <div class="form-floating mb-3">
                                                <input type="password" class="form-control" name="lgpassword" id="lgpassword" placeholder="Password" required>
                                                <label for="password" class="form-label">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="d-grid">
                                                <button class="btn btn-primary btn-lg" type="submit" name="login_btn" id="login_btn">Login</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                                            <p class="m-0 text-secondary text-center">Send OTP to <a href="login_otp.php" class="link-primary text-decoration-none">Login</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-4">
                                            <p class="m-0 text-secondary text-center">Don't have an account <a href="register.php" class="link-primary text-decoration-none">Register</a></p>
                                        </div>
                                    </div>
                                </div>
                               
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


</body>
</html>