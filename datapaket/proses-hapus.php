<?php 
include("../connection.php");

if(isset($_GET['idk'])){
    $delete = mysqli_query($conn, "DELETE FROM tb_paket WHERE id_paket = '".$_GET['idk']."'");
        echo "<script>location='data-paket.php';</script>";   
}
?>