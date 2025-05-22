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
    <link rel="stylesheet" href="css/profil.css">

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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <nav>
        <div class="navigasi-atas">
            <div class="logo">
                <a href="index.php"><img src="asset/Tanpa judul (200 x 40 piksel) (1).png" class="hitam"></a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="about.html">About us</a></li>
                    <li><a href="category1.html">Category</a></li>
                    <li><a href="profil.php" class="active">Profil</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- conten -->
    <div class="section">
        <div class="container">
            <h1>Profil <br><br>
                <p class="active"><?php echo $d->username ?></p>
            </h1>
            <div class="box">
                <form action="" method="POST">
                    <input type="text" name="username" placeholder="username" class="input-control" required value="<?php echo $d->username ?>">
                    <input type="email" name="user_email" placeholder="example@gmail.com" class="input-control" required value="<?php echo $d->user_email ?>">
                    <input type="text" name="user_telp" placeholder="081234567890" class="input-control <?php echo empty($d->user_telp) ? 'warning' : ''; ?>" value="<?php echo $d->user_telp ?>">

                    <input type="text" name="user_addres" placeholder="Jl. Merdeka No. 10, Jakarta" class="input-control <?php echo empty($d->user_address) ? 'warning' : ''; ?>" value="<?php echo $d->user_address ?>">
                    <input type="submit" name="submit" value="Ubah profil" class="btn">
                    <a href="keluar.php"><input type="text" name="submit" value="Keluar" class="btn-active"></a>
                </form>

                <?php
                if (isset($_POST['submit'])) {
                    $username = $_POST['username'];
                    $user_email = $_POST['user_email'];
                    $user_telp = $_POST['user_telp'];
                    $user_addres = $_POST['user_addres'];

                    $update = mysqli_query($conn, "UPDATE tb_user SET 
                    username = '" . $username . "',
                    user_email = '" . $user_email . "',
                    user_telp = '" . $user_telp . "',
                    user_address = '" . $user_addres . "' 
                    WHERE ID_user = '" . $d->ID_user . "'");

                    if ($update) {
                        echo "<script>alert('Perubahan Sukses!'); 
        location.href='profil.php';</script>";
                    }
                }
                ?>
            </div>

            </h1>
            <div class="box">
                <form action="" method="POST">
                    <input type="password" name="pas1" placeholder="Password baru" class="input-control" required value="">
                    <input type="password" name="pas2" placeholder="Konfirmasi password" class="input-control" required value="">
                    <input type="submit" name="submit2" value="Ubah Password" class="btn">
                </form>

                <?php
                if (isset($_POST['submit2'])) {
                    $pass1 = $_POST['pas1'];
                    $pass2 = $_POST['pas2'];

                    if ($pass1 != $pass2) {
                        echo '<script>alert("Konfirmasi Pasword tidak sesuai")</script>';
                    } else {
                        $u_pass = mysqli_query($conn, "UPDATE tb_user SET 
                    password = '" . $pass1 . "' 
                    WHERE ID_user = '" . $d->ID_user . "'");

                        if ($u_pass) {
                            echo "<script>alert('Perubahan Sukses!'); 
        location.href='profil.php';</script>";
                        } else {
                            echo 'gagal';
                        }
                    }
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

</html>