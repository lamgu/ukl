<?php
include 'connection.php';

?>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ExplorJatim.com</title>
    <link rel="stylesheet" href="reset.css">
    <link rel="stylesheet" href="css/login.css">

    <!-- my font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wdth,wght@104.4,300..700&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
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

    <div class="background"></div>
    <div class="container">

        <div class="content">
            <h3>Explor<span>Jatim</span>
            </h3>

            <div class="text-sci">
                <h2>Sugeng Rawuh</h2>

                <p>
                    <span>Di website kami!</span> Jelajahi keindahan budaya, wisata, dan kuliner khas Jawa Timur bersama
                    kami. Silakan login untuk memulai petualanganmu dan temukan pesona Jawa Timur di setiap langkah!
                </p>

                <div class="sosial-icons">
                    <a href=""><i class='bx bxl-google'></i></a>
                    <a href=""><i class='bx bxl-twitter'></i></a>
                    <a href=""><i class='bx bxl-whatsapp'></i></a>
                    <a href=""><i class='bx bxl-instagram-alt'></i></a>
                </div>
            </div>
        </div>
        <div class="logreg-box">
            <div class="form-box login">
                <form action="proses.php" method="POST">
                    <h2> Masuk</h2>
                    <div class="input-box">
                        <span class="icon"><i class='bx bx-envelope'></i></span>
                        <input type="email" name="namlog" id="" required>
                        <label for="">Email</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-lock-open-alt'></i></span>
                        <input type="password" name="paslog" id="" required>
                        <label for="">Password</label>
                    </div>

                    <div class="remember-forgot">
                        <label for=""><input type="checkbox"> Remember me</label>
                        <a href="#">Lupa Password?</a>
                    </div>

                    <button type="submit" name="submit" class="btn">Masuk</button>

                    <div class="login-register">
                        <p>Tidak memiliki akun? <a href="#" class="register-link">Daftar</a></p>
                    </div>
                </form>
            </div>
            <div class="form-box register">
                <form action="proses.php" method="post">
                    <h2> Daftar</h2>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-user'></i></span>
                        <input type="text" name="namreg" id="" required>
                        <label for="">Nama</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-cake'></i></span>
                        <input type="datetime" name="date" id="" required>
                        <label for="">Tanggal lahir</label>
                    </div>


                    <div class="input-box">
                        <span class="icon"><i class='bx bx-envelope'></i></span>
                        <input type="email" name="email" id="" required>
                        <label for="">Email</label>
                    </div>

                    <div class="input-box">
                        <span class="icon"><i class='bx bx-lock-open-alt'></i></span>
                        <input type="password" name="pasreg" id="" required>
                        <label for="">Password</label>
                    </div>

                    <div class="remember-forgot">
                        <label for=""><input type="checkbox"> I agree to the terms & conditions</label>
                    </div>

                    <button type="submit" name="daftar" class="btn">Daftar</button>

                    <div class="login-register">
                        <p>Sudah memiliki akun? <a href="#" class="login-link">masuk</a></p>
                    </div>
            </div>
        </div>

        <script src="js/login.js"></script>
</body>