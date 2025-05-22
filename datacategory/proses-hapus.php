<?php

include '../connection.php';

if (isset($_GET['idk'])) {
    $delete = mysqli_query($conn, "DELETE FROM tb_category WHERE ID_category = '" . $_GET['idk'] . "' ");
    echo "<script>location='datacategory.php';</script>";
}


