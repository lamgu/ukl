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
                    <li><a href="../datacategory/datacategory.php">Category</a></li>
                    <li><a href="data-produk.php" class="active">Produk</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- conten -->
    <div class="section">
        <div class="container">
            <h1>Tambah<p class="active">Data Produk</p>
            </h1>
            <div class="box">
                <form action="" method="POST" enctype="multipart/form-data">
                    <!-- mengirim data file -->
                    <select class="input-control" name="kategori" required>
                        <option value="">---Pilih Kategori--</option>
                        <?php
                        $kategori = mysqli_query($conn, "SELECT * FROM tb_category ORDER BY ID_category DESC");
                        while ($r = mysqli_fetch_array($kategori)) {
                        ?>
                            <option value="<?php echo $r['ID_category'] ?>"><?php echo $r['category_name'] ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <input type="text" name="nama" class="input-control" placeholder="Nama Objek" required>
                    <input type="text" name="Harga" class="input-control" placeholder="Harga" required>
                    <input type="file" name="Gambar" class="input-control" required>
                    <textarea name="deskripsi" class="input-control" id="deskripsi" placeholder="Deskripsi" rows="7" required></textarea><br>


                    <select name="status" class="input-control"
                        <option value="">--Pilih Status-- </option>
                        <option value="1">Aktif</option>
                        <option value="0">Tidak aktif</option>
                    </select>

                    <input type="submit" name="submit" value="Tambah" class="btn">
                    <a href="data-produk.php"><input type="text" name="submit" value="kembali" class="btn-active"></a>
                </form>

                <?php
                if (isset($_POST['submit'])) {

                    //print_r($_FILES['Gambar']);

                    //menampung inputan dari form
                    $kategori  = $_POST['kategori'];
                    $nama      = $_POST['nama'];
                    $harga     = $_POST['Harga'];
                    $deskripsi = $_POST['deskripsi'];
                    $ID_user   = $_SESSION['id'];
                    $status    = $_POST['status'];


                    //menampung data field yang diupload

                    $filename = $_FILES['Gambar']['name'];
                    //mengambil nama file
                    $tmp_name = $_FILES['Gambar']['tmp_name'];
                    //Mengambil lokasi file sementara di server

                    $type1 = explode('.', $filename);
                    //memisahkan string berdasarkan tanda '.' dari array 1
                    $type2 = end($type1);
                    //memastikan selalu mendapatkan ekstensi terakhir

                    //rename
                    $newname = 'Produk' . time() . '.' . $type2;

                    //tipe format yang diizinkan
                    $tipe_diizinkan = array('jpg', 'png', 'jpeg');

                    //validasi format file
                    if (!in_array($type2, $tipe_diizinkan))
                    //mengecek  apakah suatu nilai tidak ada di dalam array.
                    {
                        echo "<script>alert(Format file tidak di izinkan)</script>";
                    } else {
                        //jika format file benar

                        //proses uploud file & insert ke dalam database
                        move_uploaded_file($tmp_name, '../produk/' . $newname);

                        $insert = mysqli_query($conn, "INSERT INTO tb_post VALUES (
                        null, '$kategori', '$nama', '$harga', '$deskripsi', '$newname', null, '$ID_user', '$status'
                        )");

                        if ($insert) {
                            echo "<script>alert('Data berhasil di tambahkan'); location='data-produk.php';</script>";
                        } else {
                            echo "Gagal: " . mysqli_error($conn);
                        }
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>


</html>