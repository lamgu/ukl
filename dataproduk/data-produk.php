<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['login']) || $_SESSION['level'] != 'admin') {
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
    <nav>
        <div class="navigasi-atas">
            <div class="logo">
                <a href="../index.html"><img src="../asset/Tanpa judul (200 x 40 piksel) (1).png" class="hitam"></a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="../admin.php">Home</a></li>
                    <li><a href="../profil.php">Profil</a></li>
                    <li><a href="../datacategory/datacategory.php">Category</a></li>
                    <li><a href="../dataproduk/data-produk.php" class="active">Produk</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="section">
        <div class="container">
            <h1>Data Produk</h1>
            <div class="box">
                <p><a href="tambah-produk.php">Tambah Data</a></p>
                <table border="1" cellspacing="0" class="table">
                    <thead>
                        <tr>
                            <th width="60px">No</th>
                            <th>Category</th>
                            <th>Nama</th>
                            <th>Harga</th>
                            <th>Gambar</th>
                            <th>status</th>
                            <th>ID_user</th>

                            <th width="170px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $no = 1;
                        $produk = mysqli_query($conn, "SELECT * FROM tb_post LEFT JOIN tb_category USING (ID_category) ORDER BY ID_post DESC");
                        if (mysqli_num_rows($produk)) {
                            // mengurutkan dari yang terbaru ke terlama
                            while ($row = mysqli_fetch_array($produk)) {
                                //mengambil data setiap baris dalam bentuk array
                        ?>
                                <tr>
                                    <td><?php echo $no++ ?></td>
                                    <td><?php echo $row['category_name'] ?></td>
                                    <td><?php echo $row['nama_wisata'] ?></td>
                                    <td>Rp. <?php echo number_format($row['harga_wisata']) ?></td>
                                    <td><a href="../produk/<?php echo $row['foto_wisata'] ?>"><img src="../produk/<?php echo $row['foto_wisata'] ?>" width="50px"></a></td>
                                    <td><?php echo ($row['status'] == 0) ? 'Tidak aktif' : 'Aktif'; ?></td>
                                    <td><?php echo $row['ID_user'] ?></td>

                                    <td>
                                        <a href="edit-produk.php?id=<?php echo $row['ID_post'] ?>" class="edit">Edit</a> | <a href="proses-hapus.php?idp=<?php echo $row['ID_post'] ?>" onclick="return confirm('Yakin Ingin Hapus?')" class="hapus">Hapus</a>
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