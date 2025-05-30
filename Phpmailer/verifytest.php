<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
// simple mail transfer protokol (SMTP)
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'ghulam.nawwaf@gmail.com';                     //SMTP username
    $mail->Password   = 'srtpwlfqsejusuba';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom('ghulam.nawwaf@gmail.com', 'Ghulam Nawwaf');
    $mail->addAddress('nawwafgaming22@gmail.com', 'user');     //Add a recipient             //Name is optional
    $mail->addReplyTo('no-reply@example.com', 'Information');

    //Content   
    $mail->isHTML(true);
    $email_template = "
    <h1>Kamu telah melakukan pendaftaran akun ghulam.nawwaf</h1>
    <h4>Verifikasi Emailmu agar dapat login, klik tautan berikut !</h4>
    <a href='#'>Klik Disini</a>
    ";                                  //Set email format to HTML
    $mail->Subject = 'Verifikasi Email';
    $mail->Body    = $email_template;

    $mail->send();
    echo 'Email Terkirim';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
