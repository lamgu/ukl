<?php
session_start();
include '../connection.php';

$id = $_GET['id'];
mysqli_query($conn, "DELETE FROM tb_pemesanan WHERE ID_order = '$id'");
header("location: ../profil.php");
