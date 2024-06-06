<?php
session_start();
include "config.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if(isset($_POST['send_otp_btn'])){
    $email = mysqli_real_escape_string($conn, $_POST['lgemail_otp']);
    
    $select_query = "SELECT * FROM users WHERE email='$email' AND status='active'";
    $result_select = mysqli_query($conn, $select_query);
    
    if(mysqli_num_rows($result_select) > 0){
        $otp = rand(100000, 999999);
        $otp_generated_at = date('Y-m-d H:i:s'); 
        
        $sql_update = "UPDATE users SET otp='$otp', otp_generated_at='$otp_generated_at' WHERE email='$email'";
        $result_update = mysqli_query($conn, $sql_update);
        
        if($result_update){
            sendotp($email, $otp);
            echo "<script>alert('OTP has been sent to your email.'); window.location.href='login_otp.php';</script>";
        } else {
            echo "<script>alert('Failed to generate OTP.'); window.location.href='login_otp.php';</script>";
        }
    } else {
        echo "<script>alert('Invalid Email or User not active.'); window.location.href='login_otp.php';</script>";
    }
}

if(isset($_POST['login_otp_btn'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $otp = mysqli_real_escape_string($conn, $_POST['lg_otp']);
    
    $verify_query = "SELECT * FROM users WHERE email='$email' AND otp='$otp'";
    $result_verify = mysqli_query($conn, $verify_query);
    
    if(mysqli_num_rows($result_verify) > 0){
        $rowLogin = mysqli_fetch_assoc($result_verify);
        $otp_generated_at = strtotime($rowLogin['otp_generated_at']);
        $current_time = time();
        
        if(($current_time - $otp_generated_at) > 120){
            echo "<script>alert('OTP has expired.'); window.location.href='login_otp.php';</script>";
        } else {
            $_SESSION['uid'] = $rowLogin['id'];
            $name = $rowLogin['firstname'];
            
            setcookie("username", $name, time() + (86400 * 30), "/"); // 86400 = 1 day
            
            $last_login = date('Y-m-d H:i:s');
            $sql_update = "UPDATE users SET last_login='$last_login' WHERE id=".$rowLogin['id'];
            mysqli_query($conn, $sql_update);
            
            header("Location: home.php");
            exit();
        }
    } else {
        echo "<script>alert('Invalid OTP.'); window.location.href='login_otp.php';</script>";
    }
}

function sendotp($email, $otp) {
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
        $msg_body = "<p>To Login Enter this OTP: <b>$otp</b></p>";
        $mail->Body = $msg_body;

        $mail->send();
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
