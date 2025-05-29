<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require './Phpmailer/vendor/autoload.php';
session_start();
include 'login.php';
include 'connection.php';

$mail = new PHPMailer(true);

//membikin login
if (isset($_POST['submit'])) {

    $user = mysqli_real_escape_string($conn, $_POST['namlog']);
    $pass = mysqli_real_escape_string($conn, $_POST['paslog']);
    //mencegah karakter tertentu

    $cek = mysqli_query($conn, "SELECT * FROM tb_user WHERE user_email = '" . $user . "' AND password = '" . $pass . "'");
    if (mysqli_num_rows($cek) > 0) {
        $d =  mysqli_fetch_object($cek);
        $_SESSION["login"] = true;
        $_SESSION['a_global'] = $d;
        $_SESSION['id'] = $d->ID_user;
        $_SESSION['level'] = $d->level;

        // Cek level pengguna
        if ($d->level == 'admin') {
            echo '<script>location.href="admin.php";</script>';
        } else {
            echo '<script>location.href="index.php";</script>';
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


    $query = "INSERT INTO tb_user (username, tanggal_lahir, user_email, password) VALUES ('$nama', '$tanggal', '$email', '$password')";

    $sql = mysqli_query($conn, $query);
    if ($sql) {
        echo "<script>alert('Registasi Sukses!, Silahkan Login ulang'); 
        location.href='login.php';</script>";
    } else {
        echo '<script>alert("username/password tidak sesuai.");</script>';
    }
}
