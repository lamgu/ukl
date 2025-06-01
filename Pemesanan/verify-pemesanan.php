<?php
require('../connection.php');
session_start();

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $verify_query = "SELECT ID_order, verify_token, verify_status FROM tb_pemesanan WHERE verify_token = '$token' LIMIT 1";
    $verify_sql = mysqli_query($conn, $verify_query);
    $result = mysqli_fetch_assoc($verify_sql);

    if ($result) {
        $id_pemesanan = $result['ID_order'];

        if ($result['verify_status'] == '0') {
            $update_query = "UPDATE tb_pemesanan SET verify_status = '1' WHERE verify_token = '$token'";
            $update_sql = mysqli_query($conn, $update_query);

            if ($update_sql) {
                $_SESSION['status'] = "Sukses, email berhasil diverifikasi!";
            } else {
                $_SESSION['status'] = "Terjadi kesalahan saat memperbarui status verifikasi.";
            }
        } else {
            $_SESSION['status'] = "Sukses, email sudah diverifikasi sebelumnya!";
        }

        header("Location: konfirmasi-pesanan.php?id_pemesanan=$id_pemesanan");
        exit();
    } else {
        $_SESSION['status'] = "Ups, token anda tidak valid atau sudah kedaluwarsa!";
        header("Location: konfirmasi-pesanan.php");
        exit();
    }
} else {
    $_SESSION['status'] = "Ups, token tidak ditemukan!";
    header("Location: konfirmasi-pesanan.php");
    exit();
}
