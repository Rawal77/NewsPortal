<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

ob_start();
//Load Composer's autoloader
require 'vendor/autoload.php';

// function phpmailer($address,$verification_code){
    function phpmailer($address,$message){
//Create an instance; passing true enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;           //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = "smtp.gmail.com";                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'raolgins@gmail.com';                     //SMTP username
    $mail->Password   = 'lsecouksjtbgtida';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

    //Recipients
    $mail->setFrom('raolgins@gmail.com', 'NewsBuzz');
    $mail->addAddress($address);              
        // $mail->addAddress('basnetindra342@gmail.com');              

    $mail->addReplyTo('bisssbeee@gmail.com', 'demo');



    //Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'News';
    $mail->Body    = $message;
    $mail->send();
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
}