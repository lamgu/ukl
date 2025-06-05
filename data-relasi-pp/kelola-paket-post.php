<?php
session_start();
include '../connection.php';

if (!isset($_SESSION['login']) || $_SESSION['level'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// Ambil semua paket untuk dropdown
$pakets = mysqli_query($conn, "SELECT * FROM tb_paket");

// Ambil ID Paket yang dipilih
$id_paket = isset($_GET['id_paket']) ? $_GET['id_paket'] : '';

if ($id_paket) {
    if (isset($_GET['add_post'])) {
        $id_post = $_GET['add_post'];
        mysqli_query($conn, "INSERT INTO tb_paket_post (id_paket, id_post) VALUES ('$id_paket', '$id_post')");
        header("Location: kelola-paket-post.php?id_paket=$id_paket");
        exit();
    }

    if (isset($_GET['remove_post'])) {
        $id_post = $_GET['remove_post'];
        mysqli_query($conn, "DELETE FROM tb_paket_post WHERE id_paket = '$id_paket' AND id_post = '$id_post'");
        header("Location: kelola-paket-post.php?id_paket=$id_paket");
        exit();
    }

    $paket = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM tb_paket WHERE id_paket = '$id_paket'"));
    $selected_posts = mysqli_query($conn, "SELECT tb_post.* FROM tb_post
        JOIN tb_paket_post ON tb_post.id_post = tb_paket_post.id_post
        WHERE tb_paket_post.id_paket = '$id_paket'");
    $available_posts = mysqli_query($conn, "SELECT * FROM tb_post
        WHERE id_post NOT IN (
            SELECT id_post FROM tb_paket_post WHERE id_paket = '$id_paket'
        )");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Kelola Produk dalam Paket</title>
    <style>
        .container { width: 80%; margin: auto; }
        .box { border: 1px solid #ddd; padding: 10px; margin-bottom: 20px; }
        h2 { margin-top: 40px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Kelola Produk dalam Paket</h1>

        <form method="GET">
            <label>Pilih Paket:</label>
            <select name="id_paket" onchange="this.form.submit()">
                <option value="">-- Pilih Paket --</option>
                <?php while ($row = mysqli_fetch_assoc($pakets)) { ?>
                    <option value="<?= $row['id_paket']; ?>" <?= ($row['id_paket'] == $id_paket) ? 'selected' : '' ?>>
                        <?= $row['nama_paket']; ?>
                    </option>
                <?php } ?>
            </select>
        </form>

        <?php if ($id_paket): ?>
            <h2>Paket: <?= $paket['nama_paket'] ?></h2>

            <div class="box">
                <h3>Produk dalam Paket</h3>
                <ul>
                    <?php while ($post = mysqli_fetch_assoc($selected_posts)) { ?>
                        <li>
                            <?= $post['nama_wisata']; ?>
                            <a href="?id_paket=<?= $id_paket ?>&remove_post=<?= $post['ID_post']; ?>">[Hapus]</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>

            <div class="box">
                <h3>Tambah Produk ke Paket</h3>
                <ul>
                    <?php while ($post = mysqli_fetch_assoc($available_posts)) { ?>
                        <li>
                            <?= $post['nama_wisata']; ?>
                            <a href="?id_paket=<?= $id_paket ?>&add_post=<?= $post['ID_post']; ?>">[Tambah]</a>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        <?php endif; ?>

        <a href="data-paket.php">Kembali ke Daftar Paket</a>
    </div>
</body>
</html>
