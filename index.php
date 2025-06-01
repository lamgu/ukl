<?php
session_start();
include 'connection.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
}
$query = mysqli_query($conn, "SELECT * FROM tb_user WHERE ID_user = '" . $_SESSION['id'] . "' ");
$d = mysqli_fetch_object($query);

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExplorJatim.com</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="css/style.css">

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
                <a href="index.html"><img src="asset/Tanpa judul (200 x 40 piksel) (1).png" class="hitam"></a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.html" class="active">Home</a></li>
                    <li><a href="about.html">About us</a></li>
                    <li><a href="category1.html">Category</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="profil.php">Pesanan</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="container">
        <header id="home">
            <video autoplay muted loop>
                <source src="asset/videoplayback.mp4" type="video/mp4" width="100%">
            </video>
        </header>

        <main>
            <section class="sambutan">
                <p class="intro1">Selamat datang <span class="active2">
                        <?php echo $d->username ?>
                    </span> di</p>
                <p class="logo2">Explor<span>Jatim</span>.com</p>
                <p class="intro2">Selamat datang di Eksplor Jatim, tempat di mana pesona Jawa Timur hadir di setiap langkah! <br>
                    Di sini, kami mengajak Anda untuk menyelami keindahan alam, kekayaan budaya, dan ragam tradisi yang membuat Jawa Timur begitu istimewa.</p>

            </section>
        </main>
    </div>

    <div class="page-2">
        <div class="wave wave-left"></div>
        <div class="wave wave-right"></div>
        <div class="container-2">
            <h1>Terbaru di Explor Jatim</h1>
            <?php
            $produk = mysqli_query($conn, "SELECT * FROM tb_post ORDER BY ID_post DESC LIMIT 3");
            if (mysqli_num_rows($produk) > 0) {
                while ($p = mysqli_fetch_array($produk)) {
            ?>
                    <a href="detail-product.php?id=<?php echo $p['ID_post'] ?>">
                        <div class="card">
                            <img src="./produk/<?php echo $p['foto_wisata'] ?>" alt="">
                            <div class="nama">
                                <?php echo $p['nama_wisata']  ?> <br>
                                <br>
                                <span>klik untuk selengkapnya</span>
                            </div>
                        </div>
                    </a>
            <?php }
            } ?>
        </div>
        <div class="selengkapnya">
            <a href="category1.html">
                <img src="./asset/bromo.jpg" alt="">
                <div class="nama">
                    <h1>Category</h1>
                </div>
            </a>
        </div>
    </div>
    <div class="batas"></div>
    <div class="page-3">
        <div class="container-3">
            <h1 class="judul">Wisata Favorit! <br><br>yang harus kamu kunjungi</h1>
            <?php
            $produk = mysqli_query($conn, "SELECT * FROM tb_post WHERE ID_category = 14 ");
            if (mysqli_num_rows($produk) > 0) {
                while ($p = mysqli_fetch_array($produk)) {
            ?>
                    <div class="wrapper">
                        <img src="./produk/<?php echo $p['foto_wisata'] ?> " alt="">
                        <h1><?php echo $p['nama_wisata'] ?></h1>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Totam neque hic, dolorum delectus nulla aliquam eius harum quis sapiente similique nostrum tempore? Temporibus enim voluptas saepe. Voluptate repellat perspiciatis quos!</p>
                    </div>
            <?php }
            } ?>
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

</html>