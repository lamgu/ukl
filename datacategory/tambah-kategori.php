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
    <link rel="stylesheet" href="../css/profil.css">

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
</head>

<body>
    <nav>
        <div class="navigasi-atas">
            <div class="logo">
                <a href="../index.php"><img src="../asset/Tanpa judul (200 x 40 piksel) (1).png" class="hitam"></a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="../admin.php">Home</a></li>
                    <li><a href="../profil.php">Profil</a></li>
                    <li><a href="datacategory.php" class="active">Category</a></li>
                    <li><a href="../dataproduk/data-produk.php">Produk</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- conten -->
    <div class="section">
        <div class="container">
            <h1>Tambah<p class="active">Data kategori</p>
            </h1>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="nama" placeholder="nama kategori" class="input-control" required>
                    <input type="submit" name="submit" value="Tambah" class="btn">
                    <a href="datacategory.php"><input type="text" name="submit" value="kembali" class="btn-active"></a>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    $nama = ucwords($_POST['nama']);

                    $insert = mysqli_query($conn, "INSERT INTO tb_category VALUES (
                        null,
                        '" . $nama . "')");
                    if ($insert) {
                        echo '<script>alert("Tambah Data berhasil"); location=" datacategory.php"; </script>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</body>

</html>