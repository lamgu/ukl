<?php
session_start();
include '../connection.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_user = $_SESSION['id']; // dari session login
    $id_post = $_POST['ID_post']; // id produk/wisata yang dipesan
    $visit_date = $_POST['visit_date'];
    $quantity = $_POST['quantity']; // jumlah pesanan
    $payment_method = $_POST['payment_method'];
    $order_date = date("Y-m-d"); // otomatis ambil tanggal hari ini
    $notified = 0; // default belum dinotifikasi
    $verify_token = md5(rand());


    // Ambil harga dari tb_post
    $query_post = mysqli_query($conn, "SELECT harga_wisata FROM tb_post WHERE ID_post = '$id_post'");
    $post = mysqli_fetch_assoc($query_post);
    $harga = $post['harga_wisata'];
    $total_harga = $harga * $quantity;

    // Insert ke tb_pemesanan ketika user masih di detail
    $query = "INSERT INTO tb_pemesanan (ID_user, ID_post, order_date, visit_date, quantity, total_harga, notified, payment_method, verify_token, verify_status)
              VALUES ('$id_user', '$id_post', '$order_date', '$visit_date', '$quantity', '$total_harga', '$notified', '$payment_method', '$verify_token', '0')";

    if (mysqli_query($conn, $query)) {
        $id_pemesanan = mysqli_insert_id($conn); // Dapatkan ID terbaru yang baru disimpan
        echo "<script>window.location='konfirmasi-pesanan.php?id_pemesanan=$id_pemesanan';</script>";
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($conn);
    }
}
