<?php
include "config.php";

if (isset($_POST['otp_signup_btn'])) {
    $ver_code = $_POST['ver_code'] ?? null;
    $otp = $_POST['otp_signup'] ?? null;

  
    if ($ver_code && $otp) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE verification_code = ?");
        $stmt->bind_param("s", $ver_code);
        $stmt->execute();
        $result = $stmt->get_result();

       
        if ($result->num_rows > 0) {
            $rowSelect = $result->fetch_assoc();
            $rowOtp = trim($rowSelect['otp']);
            $rowSignupTime = strtotime($rowSelect['signup_time']);
            $timeup = strtotime('+1 minute', $rowSignupTime);

            if (trim($otp) !== $rowOtp) {
                echo "<script>alert('Please Enter Correct OTP!')</script>";
            } else {
                if (time() >= $timeup) {
                    echo "<script>alert('Time Up...Please Try again!')</script>";
                    header("Refresh:1;url=register.php");
                    exit();
                } else {
                    $update_stmt = $conn->prepare("UPDATE users SET status='active' WHERE verification_code = ?");
                    $update_stmt->bind_param("s", $ver_code);
                    if ($update_stmt->execute()) {
                        echo "<script>alert('Your account is successfully Activated!')</script>";
                        header("Refresh:1;url=register.php");
                        exit();
                    } else {
                        echo "<script>alert('Oops! Something went wrong!')</script>";
                    }
                }
            }
        } else {
            echo "<script>alert('Invalid verification code. Please try again.')</script>";
        }
    } else {
        echo "<script>alert('Invalid request!')</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/registrations/registration-9/assets/css/registration-9.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>OTP</title>
</head>
<body>
<section class="bg-primary py-3 py-md-6 py-xl-8" style="height: 100vh;">
    <div class="container">
        <div class="row gy-4 justify-content-center">
            <div class="col-12 col-md-8 col-xl-6">
                <div class="custom-form-width">
                    <div class="card border-0 rounded-4">
                        <div class="card-body p-3 p-md-4 p-xl-5">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-4">
                                        <h2 class="h3">OTP Verification</h2>
                                        <h3 class="fs-6 fw-normal text-secondary m-0">Enter OTP to Verify your Email</h3>
                                    </div>
                                </div>
                            </div> 
                            <form action="verify_otp.php" method="post">
                                <input type="hidden" name="ver_code" value="<?php echo htmlspecialchars($_GET['ver_code'] ?? '', ENT_QUOTES); ?>">
                                <div class="row gy-3 overflow-hidden">
                                    <div class="col-12">
                                        <div class="form-floating mb-3">
                                            <input type="text" class="form-control" name="otp_signup" id="otp_signup" placeholder="Enter OTP" required>
                                            <label for="otp_signup" class="form-label">Enter OTP</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-lg" type="submit" name="otp_signup_btn" id="otp_signup_btn">Verify</button>
                                        </div>
                                    </div>
                                </div>
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
