<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['login']) || $_SESSION['level'] != 'admin') {
    header("Location: index.php");
    exit();
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
    <link rel="stylesheet" href="css/admin.css">

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
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wdth,wght@94.3,300..700&family=Pacifico&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet
    ">
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
                    <li><a href="admin.php" class="active">Home</a></li>
                    <li><a href="profil.php">Profil</a></li>
                    <li><a href="datacategory/datacategory.php">Kategory</a></li>
                    <li><a href="dataproduk/data-produk.php">Produk</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="layar-penuh">
        <header id="home">
            <video autoplay muted loop>
                <source src="asset/videoplayback.mp4" type="video/mp4" />
            </video>
        </header>
    </div>
    <main>
        <section class="sambutan">
            <p class="intro1">selamat datang <span class="active2">"<?php echo $d->username ?>"</span> di</p>
            <p class="logo2">Explor<span>Jatim</span>.com</p>
            <p class="intro2">Selamat datang di Eksplor Jatim, tempat di mana pesona Jawa Timur hadir di setiap langkah!
                Di
                sini, kami mengajak Anda untuk menyelami keindahan alam, kekayaan budaya, dan ragam tradisi yang membuat
                Jawa Timur begitu istimewa</p>
        </section>
    </main>
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