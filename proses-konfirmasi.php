<?php
session_start();
include 'connection.php';

if (!isset($_GET['id_order'])) {
    echo "ID order tidak ditemukan.";
    exit;
}

$id_order = $_GET['id_order'];

// Ambil data pemesanan dan user terkait
$query = "
SELECT p.ID_order, p.ID_post, p.order_date, p.visit_date, p.quantity, p.total_harga, 
       p.payment_method, p.status, u.nama AS nama_user, u.alamat, u.telp
FROM tb_pemesanan p
JOIN tb_user u ON p.ID_user = u.ID_user
WHERE p.ID_order = '$id_order'
";
$result = mysqli_query($conn, $query);

if (!$result || mysqli_num_rows($result) === 0) {
    echo "Pesanan tidak ditemukan.";
    exit;
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
    <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat']) ?></p>
    <p><strong>Telepon:</strong> <?= htmlspecialchars($data['telp']) ?></p>
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