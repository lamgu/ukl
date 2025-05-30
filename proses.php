<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


session_start();
include 'login.php';
include 'connection.php';

function kirimemail_verifikasi($email, $verify_token)
{
    require './Phpmailer/vendor/autoload.php';
    $mail = new PHPMailer(true);

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
    $mail->addAddress($email, 'user');     //Add a recipient             //Name is optional
    $mail->addReplyTo('no-reply@example.com', 'Information');

    //Content   
    $mail->isHTML(true);
    $email_template = "
    <h1>Kamu telah melakukan pendaftaran akun ghulam.nawwaf</h1>
    <h4>Verifikasi Emailmu agar dapat login, klik tautan berikut !</h4>
    <a href='http://localhost/ukl/verify-email.php?token=$verify_token'>Klik Disini</a>
    ";                                  //Set email format to HTML
    $mail->Subject = 'Verifikasi Email';
    $mail->Body    = $email_template;

    $mail->send();
    echo 'Email Terkirim';
}


//membikin login
if (isset($_POST['submit'])) {
    $user = mysqli_real_escape_string($conn, $_POST['namlog']);
    $pass = mysqli_real_escape_string($conn, $_POST['paslog']);

    $cek = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_email = '$user' AND password = '$pass'");
    if (mysqli_num_rows($cek) > 0) {
        $d = mysqli_fetch_object($cek);

        if ($d->verify_status == '1') {
            $_SESSION["login"] = true;  //indikator jika user sudah login
            $_SESSION['a_global'] = $d; //menyimpan seluruh data user ke session 
            $_SESSION['id'] = $d->ID_user; //menyimpan id user
            $_SESSION['level'] = $d->level; //level admin atau user

            if ($d->level == 'admin') {
                echo '<script>location.href="admin.php";</script>';
            } else {
                echo '<script>location.href="index.php";</script>';
            }
        } else {
            echo '<script>alert("Silakan verifikasi email terlebih dahulu.");</script>';
        }
    } else {
        echo '<script>alert("Username/password tidak sesuai.");</script>';
    }
}


//membikin registasi

if (isset($_POST['daftar'])) {
    $nama = $_POST['namreg'];
    $tanggal = $_POST['date'];
    $email = $_POST['email'];
    $password = $_POST['pasreg'];

    $verify_token = md5(rand());

    $query = "INSERT INTO tb_user (username, tanggal_lahir, user_email, password, verify_token, verify_status) VALUES ('$nama', '$tanggal', '$email', '$password', '$verify_token', '0')";

    $sql = mysqli_query($conn, $query);
    if ($sql) {
        kirimemail_verifikasi($email, $verify_token); //mengirim email verifikasi  
        echo "<script>alert('Registasi Sukses!, Silahkan Login ulang'); 
        location.href='login.php';</script>";
    } else {
        echo '<script>alert("username/password tidak sesuai.");</script>';
    }
}
