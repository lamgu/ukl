<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit();
}

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExplorJatim.com</title>
    <link rel="stylesheet" href="../reset.css">
    <link rel="stylesheet" href="../css/datacategory.css">

    <!-- my font -->
    <link rel="preconnect" href="https://fonts.goo          gleapis.com">
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

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wdth,wght@94.3,300..700&family=Pacifico&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>


</head>

<body>

    <div class="section">
        <div class="container">
            <h1>Data Pesanan</h1>
            <div class="box">
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Kategori</th>
                            <th>Nama</th>
                            <th>Tanggal Kunjungan</th>
                            <th>Harga</th>
                            <th>Jumlah</th>
                            <th>Total</th>
                            <th>Status</th>
                            <th>H-?</th>
                            <th width="170px">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $id_user = $_SESSION['id'];
                        $no = 1;
                        $query = "SELECT 
                                    tb_pemesanan.ID_order,
                                    tb_pemesanan.ID_post,
                                    tb_pemesanan.ID_user,
                                    tb_pemesanan.order_date,
                                    tb_pemesanan.visit_date,
                                    tb_pemesanan.quantity,
                                    tb_pemesanan.total_harga,
                                    tb_pemesanan.verify_status,
                                    tb_pemesanan.notified,
                                    tb_post.nama_wisata AS nama_wisata,
                                    tb_post.harga_wisata AS harga_per_item,
                                    tb_category.category_name AS nama_kategori
                                FROM tb_pemesanan
                                JOIN tb_user ON tb_pemesanan.ID_user = tb_user.ID_user
                                JOIN tb_post ON tb_pemesanan.ID_post = tb_post.ID_post
                                JOIN tb_category ON tb_post.ID_category = tb_category.ID_category
                                WHERE tb_pemesanan.ID_user = $id_user
                                ORDER BY tb_pemesanan.order_date DESC
                                ";
                        $produk = mysqli_query($conn, $query);
                        if (mysqli_num_rows($produk)) {
                            // mengurutkan dari yang terbaru ke terlama
                            while ($row = mysqli_fetch_array($produk)) {
                                //mengambil data setiap baris dalam bentuk array
                        ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row['nama_kategori'] ?></td>
                                    <td><?php echo $row['nama_wisata'] ?></td>
                                    <td><?php echo $row['visit_date'] ?></td>
                                    <td>Rp <?php echo number_format($row['harga_per_item'], 0, ',', '.') ?></td>
                                    <td><?php echo $row['quantity'] ?></td>
                                    <td>Rp <?php echo number_format($row['total_harga'], 0, ',', '.') ?></td>
                                    <td><?php if ($row['verify_status'] == 1): ?>
                                            <span style="color: green; font-weight: bold; font-size: 15px;">Ter-verifikasi</span>
                                        <?php else: ?>
                                            <span style="color: red; font-weight: bold; font-size: 10px;">Belum Ter-Verifikasi</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php
                                        $hariIni = date('Y-m-d');
                                        $visitDate = $row['visit_date'];
                                        $selisihHari = (strtotime($visitDate) - strtotime($hariIni)) / (60 * 60 * 24);

                                        if ($selisihHari > 0) {
                                            echo 'H-' . round($selisihHari);
                                        } elseif ($selisihHari == 0) {
                                            echo '<span style="color: green; font-weight: bold;">Hari ini</span>';
                                        } else {
                                            echo '<span style="color: red; font-weight: bold;">Sudah lewat</span>';
                                        }
                                        ?>
                                    </td>

                                    <td>
                                        <a href="../Pemesanan/konfirmasi-pesanan.php?id_pemesanan=<?php echo $row['ID_order'] ?>" class="edit">detail</a>
                                    </td>
                                </tr>
                            <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="10">
                                    Tidak ada data
                                </td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</body>

</html>