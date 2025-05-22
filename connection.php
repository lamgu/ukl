<?php
$hostname = 'localhost';
$username = 'root';
$password = '';
$db_name = 'web_ukl';

$conn = mysqli_connect($hostname, $username, $password, $db_name) or die ('Gagal tersambung ke dalam databse');

mysqli_select_db($conn, $db_name);
?>