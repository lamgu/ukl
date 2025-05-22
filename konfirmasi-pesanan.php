<?php
session_start();
include 'connection.php';

if (!isset($_GET['id_pemesanan'])) {
    echo "ID order tidak ditemukan.";
    exit;
}

$id_order = $_GET['id_pemesanan'];

// Ambil data pemesanan dan user terkait
$query = "SELECT 
    tb_pemesanan.ID_order,
    tb_pemesanan.ID_post,
    tb_pemesanan.ID_user,
    tb_pemesanan.order_date,
    tb_pemesanan.visit_date,
    tb_pemesanan.quantity,
    tb_pemesanan.total_harga,
    tb_pemesanan.status,
    tb_pemesanan.payment_method,
    tb_user.username AS nama_user,
    tb_user.user_address AS alamat_user,
    tb_user.user_telp AS telepon_user,
    tb_post.nama_wisata AS nama_wisata,
    tb_post.harga_wisata AS harga_per_item
FROM 
    tb_pemesanan
JOIN 
    tb_user ON tb_pemesanan.ID_user = tb_user.ID_user
JOIN 
    tb_post ON tb_pemesanan.ID_post = tb_post.ID_post
WHERE 
    tb_pemesanan.ID_order = $id_order
";
$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}


$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Konfirmasi Pesanan</title>
</head>

<body>
    <h2>Konfirmasi Pemesanan</h2>
    <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama_user']) ?></p>
    <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat_user']) ?></p>
    <p><strong>Telepon:</strong> <?= htmlspecialchars($data['telepon_user']) ?></p>
    <hr>
    <p><strong>Tanggal Pemesanan:</strong> <?= $data['order_date'] ?></p>
    <p><strong>Tanggal Kunjungan:</strong> <?= $data['visit_date'] ?></p>
    <p><strong>Jumlah:</strong> <?= $data['quantity'] ?></p>
    <p><strong>Metode Pembayaran:</strong> <?= $data['payment_method'] ?></p>
    <p><strong>Total Harga:</strong> Rp<?= number_format($data['total_harga'], 0, ',', '.') ?></p>

    <form method="post" action="proses_konfirmasi.php">
        <input type="hidden" name="id_order" value="<?= $data['ID_order'] ?>">
        <button type="submit" name="action" value="accept">Terima</button>
        <button type="submit" name="action" value="cancel">Batal</button>
    </form>
</body>

</html>