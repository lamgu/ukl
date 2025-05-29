<?php
session_start();
if (!isset($_GET['id'])) {
    echo "Data tidak ditemukan!";
    exit;
}

include 'connection.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}

$produk = mysqli_query($conn, "SELECT * FROM tb_post WHERE ID_post = '" . $_GET['id'] . "' ");
$p = mysqli_fetch_object($produk);

?>

<!-- proses like -->
<?php
if (isset($_GET['like'])) {
    $idp = $_GET['like']; // ambil ID_post
    $idu = $_SESSION['id']; // ID user saat ini

    // Cek apakah user sudah like
    $q = mysqli_query($conn, "SELECT * FROM tb_likes WHERE ID_user='$idu' AND ID_post='$idp'");
    $cekk = mysqli_fetch_assoc($q);

    if ($cekk && $cekk['ID_user'] == $idu) {
        // Jika sudah like, maka hapus (unlike)
        $sql1 = mysqli_query($conn, "DELETE FROM tb_likes WHERE ID_post='$idp' AND ID_user='$idu'");
        if ($sql1) {
            header("Location: detail-product.php?id=$idp");
        }
    } else {
        // Jika belum like, maka tambahkan like
        $sql1 = mysqli_query($conn, "INSERT INTO tb_likes (ID_like, ID_post, ID_user) VALUES (NULL, '$idp', '$idu')");
        if ($sql1) {
            header("Location: detail-product.php?id=$idp");
        }
    }
}
?>
<!-- proses komentar -->
<?php
if (isset($_POST['submit_komentar'])) {
    $id_user = $_SESSION['id'];    // id user dari session
    $id_post = $_GET['id'];         // id post dari parameter
    $komentar = mysqli_real_escape_string($conn, $_POST['komentar']); // sanitize input

    // Masukkan komentar ke database
    $query = "INSERT INTO tb_komentar (ID_user, ID_post, content_text, tanggal)
              VALUES ('$id_user', '$id_post', '$komentar', NOW())";

    if (mysqli_query($conn, $query)) {
        header("Location: detail-product.php?id=$id_post");
        exit;
    } else {
        echo "Gagal mengirim komentar: " . mysqli_error($conn);
    }
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExplorJatim.com</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="css/wisata.css">

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
    <img src="./produk/<?php echo $p->foto_wisata ?>" alt="" class="background">
    <nav>
        <div class="navigasi-atas">
            <div class="logo">
                <a href="index.html"><img src="asset/Tanpa judul (200 x 40 piksel) (1).png" class="hitam"></a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.html">About</a></li>
                    <li><a href="category1.html" class="active">Category</a></li>
                    <li><a href="profil.php">Profil</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Product detail -->
        <div class="container">
            <h4 class="active"><?php echo $p->nama_wisata ?></h4>
            <div class="box">
                <div class="col-1">
                    <img class="detail-img" src="./produk/<?php echo $p->foto_wisata ?>">
                    <?php
                    $id_p = $p->ID_post;
                    $id_u = $_SESSION['id'];

                    $cek = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_likes WHERE ID_post='$id_p'"));
                    $cek2 = mysqli_num_rows(mysqli_query($conn, "SELECT * FROM tb_likes WHERE ID_user='$id_u' AND ID_post='$id_p'"));
                    ?>
                    <div class="fitur-like">
                        <?php if ($cek2 > 0) { ?>
                            <a style="color:green" href="detail-product.php?id=<?= $p->ID_post ?>&like=<?= $id_p ?>"><i class='bx bxs-like'></i></a>

                        <?php } else { ?>
                            <a href="detail-product.php?id=<?= $p->ID_post ?>&like=<?= $id_p ?>"><i class='bx bx-like'></i></a>
                        <?php } ?>
                        <span><?= $cek ?> Likes</span>
                    </div>
                </div>
                <div class="col-2">
                    <div class="deskripsi wisata deskripsi-wisata">
                        <span>Harga :</span>
                        <h5>Rp.<?php echo number_format($p->harga_wisata) ?></h5><br>
                        <span>Deskripsi : </span>
                        <p>
                            <?php echo $p->deskripsi_wisata ?>
                        </p>
                        <button class="DeskripsiPemesanan-link">Form Pemesanan</button>
                        <div class="sosial-icons">
                            <a href=""><i class='bx bxl-google'></i></a>
                            <a href=""><i class='bx bxl-twitter'></i></a>
                            <a href=""><i class='bx bxl-whatsapp'></i></a>
                            <a href=""><i class='bx bxl-instagram-alt'></i></a>
                        </div>
                    </div>

                    <!-- Mengecek apakah user sudah mengisi form di profil? -->
                    <?php
                    $id_user = $_SESSION['id'];
                    // Cek apakah data penting kosong
                    $cek_user = mysqli_query($conn, "SELECT user_telp, user_address FROM tb_user WHERE ID_user = '$id_user'");

                    if (!$cek_user) {
                        // Jika query gagal, tampilkan pesan kesalahan
                        die("Query gagal: " . mysqli_error($conn));
                    }

                    $user = mysqli_fetch_assoc($cek_user);

                    // Cek apakah data penting kosong
                    $profil_incomplete = empty($user['user_telp']) || empty($user['user_address']);

                    ?>

                    <?php if ($profil_incomplete): ?>
                        <div class="alert">
                            <img src="./asset/Desain tanpa judul (15).png" alt="">
                            <h1> Ups.. ada yang kurang sepertinya</h1>
                            <p>Silakan lengkapi nomor telepon dan alamat di halaman profil sebelum melakukan pemesanan.</p>
                            <a href="profil.php"><button>Lengkapi Profil</button></a>
                            <br>
                            <div class="pemesanan-deskripsi">
                                <a href="#" class="DeskripsiWisata-link"><i class='bx bx-chevron-left'></i>Kembali</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="deskripsi pemesanan deskripsi-pemesanan">
                            <div class="form-box">
                                <form action="Pemesanan/proses.pemesanan.php" method="post" class="form-pemesanan">
                                    <h2>Pemesanan</h2>
                                    <input type="hidden" name="ID_post" value="<?= $_GET['id']; ?>">

                                    <div class="input-box">
                                        <input type="date" name="visit_date" required>
                                        <label for="">Tanggal tujuan</label>
                                    </div>

                                    <div class="input-box">
                                        <input type="number" name="quantity" min="1" required>
                                        <label for="">Jumlah Barang</label>
                                    </div>
                                    <div class="input-box dropdown">
                                        <select name="payment_method" id="payment_method" required class="dropdown-pm">
                                            <option value="">-- Pilih Metode Pembayaran --</option>
                                            <option value="Digital">Pembayaran Digital</option>
                                            <option value="Ditempat">Pembayaran Ditempat</option>
                                        </select>
                                    </div>
                                    <button class="PesaSekarang" type="submit" <?php if ($profil_incomplete) echo 'disabled'; ?>>
                                        Pesan Sekarang
                                    </button>
                                    <div class="pemesanan-deskripsi">
                                        <a href="#" class="DeskripsiWisata-link">Kembali</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    <?php endif; ?>


                </div>
            </div>
            <div class="fitur-komentar">
                <h3>Tambahkan Komentar</h3>
                <form action="" method="post">
                    <textarea name="komentar" placeholder="Tulis komentar kamu di sini..." required></textarea><br>
                    <button type="submit" name="submit_komentar">Kirim</button>
                </form>
                <div class="list-komentar">
                    <?php
                    $komentar = mysqli_query($conn, "SELECT tb_komentar.*, tb_user.username FROM tb_komentar 
                                        JOIN tb_user ON tb_komentar.ID_user = tb_user.ID_user
                                        WHERE ID_post = '$p->ID_post' 
                                        ORDER BY tanggal DESC");
                    if (mysqli_num_rows($komentar) > 0) {
                        while ($k = mysqli_fetch_assoc($komentar)) {
                            echo "<div class='komentar'>";
                            echo "<div class='komentar-header'>";
                            echo "<strong>" . htmlspecialchars($k['username']) . "</strong>";
                            echo "<small>" . date('d M Y H:i', strtotime($k['tanggal'])) . "</small>";
                            echo "</div>";
                            echo "<p>" . htmlspecialchars($k['content_text']) . "</p>";
                            echo "</div>";
                        }
                    } else {
                        echo "<p class='none'>Jadilah komentar pertama!</p>";
                    }
                    ?>
                </div>
            </div>
        </div>

        <footer class="footer">
            <div class="footer-container">
                <div class="footer-logo">
                    <h2>Explor<span>Jatim</span></h2>
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

<script src="js/pemesanan.js"></script>

</html>