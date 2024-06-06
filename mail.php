<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'nandinikotak05@gmail.com';                     //SMTP username
    $mail->Password   = 'nhzp ciyr tijm xehs';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('nandinikotak05@gmail.com', 'Nandini');
    $mail->addAddress('nandinikotak26@gmail.com');     //Add a recipient
   
   
    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verification Code for verify your email address';

    $msg_body="<p>For verify your email address, Enter this OTP:<b>$otp</b></p>";
    $mail->Body    = $msg_body;
   
    if($mail->send()){
        echo "<script>alert('Please Check Your Email for Verification Code')</script>";
        header("location:reg_backend.php?code=$ver_code");
    }else{
        echo "<script>alert('Message could not be sent. Mailer Error: {$mail->ErrorInfo}')</script>"; 
    }
    
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}

?>