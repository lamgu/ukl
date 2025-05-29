<?php
session_start();
include '../connection.php';

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
    <title>ExplorJatim</title>
    <link rel="stylesheet" href="../css/konfirmasi.css">
    <!-- my font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Fredoka:wght@300..700&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wght@300..700&display=swap"
        rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wght@300..700&display=swap"
        rel="stylesheet">

    <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wdth,wght@94.3,300..700&family=Pacifico&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>

    <div class="container">
        <h2 class="h2-c">Konfirmasi Pemesanan</h2>
        <p><strong>Nama:</strong> <?= htmlspecialchars($data['nama_user']) ?></p>
        <p><strong>Alamat:</strong> <?= htmlspecialchars($data['alamat_user']) ?></p>
        <p><strong>Telepon:</strong> <?= htmlspecialchars($data['telepon_user']) ?></p>
        <hr>
        <p><strong>Tanggal Pemesanan:</strong> <?= $data['order_date'] ?></p>
        <p><strong>Tanggal Kunjungan:</strong> <?= $data['visit_date'] ?></p>
        <p><strong>Jumlah:</strong> <?= $data['quantity'] ?></p>
        <p><strong>Metode Pembayaran:</strong> <?= $data['payment_method'] ?></p>
        <p class="total-harga"><strong>Total Harga:</strong> Rp<?= number_format($data['total_harga'], 0, ',', '.') ?></p>

        <div class="tombol">
            <a href="../detail-product.php?id=<?= $data['ID_post'] ?>" onclick=" return confirm('Pesanan anda diproses')"><button type="button">Terima</button></a>
            <a href="batal-pemesanan.php?id=<?= $data['ID_order'] ?>" onclick=" return confirm('Yakin ingin membatalkannya?')"><button type="button" class="batal">Batal</button></a>
        </div>
    </div>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <h2><span class="brand-explor">Explor</span><span class="brand-jatim">Jatim</span></h2>
                <br>
                <div class="social-icons">
                    <a href="#"><i class='bx bxl-meta'></i></a>
                    <a href="#"><i class='bx bxl-whatsapp'></i></a>
                    <a href="#"><i class='bx bxl-instagram'></i></a>
                    <a href=""><i class='bx bxl-twitter'></i></a>
                </div>
                <br>
                <p>&copy; 2024 ExplorJatim.</p>
            </div>
            <div class="footer-contact">
                <h3>Contact us</h3>
                <p>+62 081389742344</p>
                <p>explorjatim@gmail.com</p>
                <p>Jln Ketintang Selatan, Malang</p>
            </div>
            <div class="footer-services">
                <h3>Our Services</h3>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About Us</a></li>
                    <li><a href="#">Category</a></li>
                    <li><a href="#">Profile</a></li>
                </ul>
            </div>
        </div>
    </footer>


</body>

</html>