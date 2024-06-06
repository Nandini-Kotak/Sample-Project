<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include "config.php";

// Generate OTP and verification code
$otp = rand(100000, 999999);
$ver_code = bin2hex(random_bytes(16));

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['firstName'], $_POST['lastName'], $_POST['email'], $_POST['password'])) {
        $fname = mysqli_real_escape_string($conn, $_POST['firstName']);
        $lname = mysqli_real_escape_string($conn, $_POST['lastName']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $mobile=mysqli_real_escape_string($conn, $_POST['mobile']);
        $pwd = mysqli_real_escape_string($conn, md5($_POST['password']));

        // Check if the email is already registered
        $select_sql = "SELECT * FROM users WHERE email='$email'";
        $select_res = mysqli_query($conn, $select_sql);

        if (mysqli_num_rows($select_res) > 0) {
            $selectRow = mysqli_fetch_assoc($select_res);
            $status = $selectRow['status'];

            if ($status === 'active') {
                $response = ['status' => 'error', 'message' => 'Email already registered!'];
            } else {
                $update_sql = "UPDATE users SET firstname='$fname', lastname='$lname', mobile='$mobile',password='$pwd', otp='$otp', verification_code='$ver_code' WHERE email='$email'";
                $update_res = mysqli_query($conn, $update_sql);

                if ($update_res) {
                    sendVerificationEmail($email, $otp, $ver_code);
                    $response = ['status' => 'success', 'message' => 'Please check your email for the verification code', 'ver_code' => $ver_code];
                }
            }
        } else {
            $insert_sql = "INSERT INTO users (firstname, lastname, email, mobile,password, verification_code, otp) VALUES ('$fname', '$lname', '$email', '$mobile','$pwd', '$ver_code', '$otp')";
            $insert_res = mysqli_query($conn, $insert_sql);

            if ($insert_res) {
                sendVerificationEmail($email, $otp, $ver_code);
                $response = ['status' => 'success', 'message' => 'Please check your email for the verification code', 'ver_code' => $ver_code];
            } else {
                $response = ['status' => 'error', 'message' => 'Oops! Something went wrong, Failed to register!'];
            }
        }
    } else {
        $response = ['status' => 'error', 'message' => 'Missing required fields'];
    }
} else {
    $response = ['status' => 'error', 'message' => 'Invalid request'];
}

header('Content-Type: application/json');
echo json_encode($response);

function sendVerificationEmail($email, $otp, $ver_code) {
    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'nandinikotak05@gmail.com';
        $mail->Password = 'nhzp ciyr tijm xehs'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port = 465;

       
        $mail->setFrom('nandinikotak05@gmail.com', 'Nandini');
        $mail->addAddress($email);

       
        $mail->isHTML(true);
        $mail->Subject = 'Verification Code to Verify Your Email Address';
        $msg_body = "<p>To verify your email address, enter this OTP: <b>$otp</b></p>";
        $mail->Body = $msg_body;

        $mail->send();
    } catch (Exception $e) {
    }
}
?>