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

    <!-- Font & Icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@300..700&display=swap" rel="stylesheet">
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

            <!-- Filter Kategori -->
            <form method="get" action="">
                <label for="kategori">Filter Kategori: </label>
                <select name="kategori" id="kategori" onchange="this.form.submit()">
                    <option value="">-- Semua Kategori --</option>
                    <option value="14" <?php if(isset($_GET['kategori']) && $_GET['kategori'] == '14') echo 'selected'; ?>>Wisata</option>
                    <option value="15" <?php if(isset($_GET['kategori']) && $_GET['kategori'] == '15') echo 'selected'; ?>>Kuliner</option>
                    <option value="16" <?php if(isset($_GET['kategori']) && $_GET['kategori'] == '16') echo 'selected'; ?>>Tari</option>
                </select>
            </form>
            <br>

            <!-- Tambah Data -->
            <p><a href="tambah-produk.php">Tambah Data</a></p>

            <!-- Tabel Data Produk -->
            <table border="1" cellspacing="0" class="table">
                <thead>
                    <tr>
                        <th width="60px">No</th>
                        <th>Category</th>
                        <th>Nama</th>
                        <th>Harga</th>
                        <th>Gambar</th>
                        <th>Status</th>
                        <th>ID_user</th>
                        <th width="170px">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                $no = 1;
                $where = "";
                if (isset($_GET['kategori']) && $_GET['kategori'] != "") {
                    $kategori = $_GET['kategori'];
                    $where = "WHERE tb_post.ID_category = $kategori";

                    // Tampilkan label kategori yang dipilih
                    $judulKategori = mysqli_fetch_assoc(mysqli_query($conn, "SELECT category_name FROM tb_category WHERE ID_category = $kategori"))['category_name'];
                    echo "<tr><td colspan='8'><strong>Menampilkan kategori: <em>$judulKategori</em></strong></td></tr>";
                }

                $produk = mysqli_query($conn, "SELECT * FROM tb_post LEFT JOIN tb_category USING (ID_category) $where ORDER BY ID_post DESC");

                if (mysqli_num_rows($produk)) {
                    while ($row = mysqli_fetch_array($produk)) {
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
                                <a href="edit-produk.php?id=<?php echo $row['ID_post'] ?>" class="edit">Edit</a> |
                                <a href="proses-hapus.php?idp=<?php echo $row['ID_post'] ?>" onclick="return confirm('Yakin Ingin Hapus?')" class="hapus">Hapus</a>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo "<tr><td colspan='8'>Tidak ada data produk.</td></tr>";
                }
                ?>
                </tbody>
            </table>

        </div>
    </div>
</div>

</body>
</html>
