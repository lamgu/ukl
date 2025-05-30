<?php
require('connection.php');
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT verify_token, verify_status FROM tb_user WHERE verify_token = '$token' LIMIT 1";
    $verify_sql = mysqli_query($conn, $verify_query);
    $result = mysqli_fetch_assoc($verify_sql);

    if ($result) {
        if ($result['verify_status'] == '0') {
            $update_query = "UPDATE tb_user SET verify_status = '1' WHERE verify_token = '$token'";
            $update_sql = mysqli_query($conn, $update_query);

            if ($update_sql) { //jika sudah di proses diphp
                $_SESSION['status'] = "Sukses, email berhasil diverifikasi!";
                header('location: index.php');
                exit();
            }
        } else { //jika sudah di verifikasi 
            $_SESSION['status'] = "Sukses, email sudah diverifikasi sebelumnya!";
            header('location: index.php');
            exit();
        }
    } else { //jika token tidak ditemukan
        $_SESSION['status'] = "Ups, token anda tidak valid atau sudah kedaluwarsa!";
        header('location: index.php');
        exit();
    }
} else { //jika tidak memiliki token
    $_SESSION['status'] = "Ups, token tidak ditemukan!";
    header('location: index.php');
    exit();
}

?>