<?php
session_start();
include 'connection.php';

if (!isset($_SESSION["login"])) {
    header("Location: login.php");
    exit;
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

    <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wdth,wght@94.3,300..700&family=Pacifico&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="tombol-kembali">
        <a href="javascript:history.back()"><i class='bx bx-arrow-back'></i></a>
    </div>
    <div class="section">
        <div class="container">
            <?php
            $category = mysqli_query($conn, "SELECT category_name FROM tb_category WHERE ID_category = '" . $_GET['id_category'] . "'");
            $p = mysqli_fetch_object($category)
            ?>
            <h4><?php echo $p->category_name ?><span> Di Jawatimur</span></h4>
            <div class="box">
                <?php
                //mengambil ID
                $id_category = isset($_GET['id_category']) ? $_GET['id_category'] : null;
                $produk = mysqli_query(
                    $conn,
                    "SELECT tb_post.*, tb_category.category_name 
                    FROM tb_post  
                    LEFT JOIN tb_category ON tb_post.ID_category = tb_category.ID_category  
                    WHERE tb_post.ID_category = '$id_category'
                    ORDER BY tb_post.ID_post DESC 
                    LIMIT 8;"
                );

                if (mysqli_num_rows($produk) > 0) {
                    while ($p = mysqli_fetch_array($produk)) {
                        //looping
                ?>
                        <a href="detail-product.php?id=<?php echo $p['ID_post'] ?>">
                            <div class="col-4">
                                <img src="./produk/<?php echo $p['foto_wisata'] ?>">
                                <p class="nama"><?php echo $p['nama_wisata'] ?></p>
                                <p class="harga">Rp. <?php echo number_format($p['harga_wisata']) ?></p>
                            </div>
                        </a>
                    <?php }
                } else { ?>
                    <p>Produk tidak tersedia</p>
                <?php } ?>
            </div>
        </div>
    </div>

</body>

</html>