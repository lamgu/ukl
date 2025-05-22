<?php

include '../connection.php';

if (isset($_GET['idp'])) {
    $gambar = mysqli_query($conn, "SELECT foto_wisata FROM tb_post WHERE ID_post = '".$_GET['idp']."'");
    $g = mysqli_fetch_object($gambar);
    unlink('../produk/' .$g->foto_wisata);
    //menghapus foto

    $delete = mysqli_query($conn, "DELETE FROM tb_post WHERE ID_post = '" . $_GET['idp'] . "'");
    echo "<script>location='data-produk.php';</script>";
}
