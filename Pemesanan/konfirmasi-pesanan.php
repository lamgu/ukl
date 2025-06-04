<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

session_start();
include '../connection.php';

if (isset($_SESSION['status'])) {
    $message = addslashes($_SESSION['status']); // untuk hindari error JS jika ada kutip
    echo "<script>alert('$message');</script>";
    unset($_SESSION['status']);
}
//php mailer
function kirimemail_verifikasi_pemesanan($email, $verify_token, $id_order, $nama_wisata, $total_harga)
{
    require '../Phpmailer/vendor/autoload.php';
    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ghulam.nawwaf@gmail.com';
        $mail->Password = 'srtpwlfqsejusuba';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        $mail->setFrom('ghulam.nawwaf@gmail.com', 'ExplorJatim');
        $mail->addAddress($email);
        $mail->addReplyTo('no-reply@example.com', 'No Reply');

        $mail->isHTML(true);
        $mail->Subject = 'Verifikasi Pemesanan Anda';
        $mail->Body = "<h3>Terima kasih telah melakukan pemesanan di ExplorJatim.</h3>
       <h2>Anda melakukan pemesanan produk/tiket " . htmlspecialchars($nama_wisata) . " dengan total harga</h2>
       <br> <h1>" . htmlspecialchars($total_harga) . "</h1>
        <p>Silakan verifikasi pemesanan Anda dengan klik tautan berikut:</p>
        <a href='http://localhost/ukl/Pemesanan/verify-pemesanan.php?token=$verify_token&id_order=$id_order'>Verifikasi Pemesanan</a>";
        $mail->send();
        echo "<script>alert('Email verifikasi telah dikirim. Silakan cek email Anda.');</script>";
    } catch (Exception $e) {
        echo "<script>alert('Gagal mengirim email: {$mail->ErrorInfo}');</script>";
    }
}

if (!isset($_GET['id_pemesanan'])) {
    echo "ID order tidak ditemukan.";
    exit;
}

$id_order = $_GET['id_pemesanan'];

// <--- UPDATE --->
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aksi = $_POST['aksi'] ?? '';

    if ($aksi === 'update') {
        // Logika update data
        $nama_user = mysqli_real_escape_string($conn, $_POST['nama_user']);
        $alamat_user = mysqli_real_escape_string($conn, $_POST['alamat_user']);
        $telepon_user = mysqli_real_escape_string($conn, $_POST['telepon_user']);
        $visit_date = mysqli_real_escape_string($conn, $_POST['visit_date']);
        $quantity = (int)$_POST['quantity'];
        $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);
        $id_post = $_POST['ID_post'];

        // Total harga
        $query_post = mysqli_query($conn, "SELECT harga_wisata FROM tb_post WHERE ID_post = '$id_post'");
        $post = mysqli_fetch_assoc($query_post);
        $harga = $post['harga_wisata'];
        $total_harga = $harga * $quantity;

        // Update user dan pemesanan
        mysqli_query($conn, "UPDATE tb_user 
            JOIN tb_pemesanan ON tb_user.ID_user = tb_pemesanan.ID_user
            SET 
                username = '$nama_user',
                user_address = '$alamat_user',
                user_telp = '$telepon_user'
            WHERE tb_pemesanan.ID_order = $id_order");

        mysqli_query($conn, "UPDATE tb_pemesanan SET 
            visit_date = '$visit_date',
            quantity = '$quantity',
            total_harga = '$total_harga',
            payment_method = '$payment_method'
            WHERE ID_order = $id_order");

        echo "<script>alert('Pemesanan berhasil diperbarui'); window.location='konfirmasi-pesanan.php?id_pemesanan=$id_order';</script>";
        exit;
    }

    // <--- VERIFIKASI --->

    if ($aksi === 'verifikasi') {
        // Logika kirim email
        $email = $_POST['email_user'];
        $verify_token = $_POST['verify_code'];
        $id_order = $_POST['id_order'];
        $nama_wisata = $_POST['nama_wisata'] ?? '';
        $total_harga = $_POST['total_harga'];
        kirimemail_verifikasi_pemesanan($email, $verify_token, $id_order, $nama_wisata, $total_harga);
    }
}

$query = "SELECT 
    tb_pemesanan.ID_order,
    tb_pemesanan.ID_post,
    tb_pemesanan.ID_user,
    tb_pemesanan.order_date,
    tb_pemesanan.visit_date,
    tb_pemesanan.quantity,
    tb_pemesanan.total_harga,
    tb_pemesanan.payment_method,
    tb_pemesanan.verify_token,
    tb_pemesanan.verify_status,
    tb_user.username AS nama_user,
    tb_user.user_email AS user_email,
    tb_user.user_address AS alamat_user,
    tb_user.user_telp AS telepon_user,
    tb_post.nama_wisata AS nama_wisata,
    tb_post.harga_wisata AS harga_per_item
FROM 
    tb_pemesanan
JOIN 
    tb_user ON tb_pemesanan.ID_user = tb_user.ID_user
JOIN 
    tb_post ON tb_pemesanan.ID_post = tb_post.ID_post
WHERE 
    tb_pemesanan.ID_order = $id_order";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query Error: " . mysqli_error($conn));
}

$data = mysqli_fetch_assoc($result);
?>


<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>ExplorJatim</title>
    <link rel="stylesheet" href="../css/konfirmasi.css">
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

    <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Anton&family=Bebas+Neue&family=Dancing+Script:wght@400..700&family=Fasthand&family=Fredoka:wdth,wght@94.3,300..700&family=Pacifico&family=Raleway:ital,wght@0,100..900;1,100..900&display=swap" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2 class="h2-c">Konfirmasi Pemesanan <?= $data['nama_wisata'] ?></h2>
        <hr>
        <form action="konfirmasi-pesanan.php?id_pemesanan=<?= $data['ID_order'] ?>" method="post">
            <input type="hidden" name="aksi" value="update">
            <input type="hidden" name="ID_order" value="<?= $data['ID_order'] ?>">
            <input type="hidden" name="ID_post" value="<?= $data['ID_post'] ?>">


            <label><strong>Nama:</strong></label>
            <input type="text" name="nama_user" value="<?= htmlspecialchars($data['nama_user']) ?>" required>
            <label><strong>Alamat:</strong></label>
            <textarea name="alamat_user" required><?= htmlspecialchars($data['alamat_user']) ?></textarea>

            <label><strong>Telepon:</strong></label>
            <input type="text" name="telepon_user" value="<?= htmlspecialchars($data['telepon_user']) ?>" required>

            <hr>

            <label><strong>Tanggal Pemesanan:</strong></label>
            <input type="date" name="order_date" value="<?= $data['order_date'] ?>" required>

            <label><strong>Tanggal Kunjungan:</strong></label>
            <input type="date" name="visit_date" value="<?= $data['visit_date'] ?>" required>

            <label><strong>Jumlah:</strong></label>
            <input type="number" name="quantity" value="<?= $data['quantity'] ?>" min="1" required>

            <label><strong>Metode Pembayaran:</strong></label>
            <select name="payment_method" required>
                <option value="Transfer Bank" <?= $data['payment_method'] == 'Transfer Bank' ? 'selected' : '' ?>>Transfer Bank</option>
                <option value="Bayar di Tempat" <?= $data['payment_method'] == 'Bayar di Tempat' ? 'selected' : '' ?>>Bayar di Tempat</option>
            </select>

            <hr>

            <p class="total-harga"><strong>Total Harga:</strong> Rp<?= number_format($data['total_harga'], 0, ',', '.') ?></p>

            <div class="tombol">
                <button type="submit">Update</button>
                <a href="batal-pemesanan.php?id=<?= $data['ID_order'] ?>" onclick="return confirm('Yakin ingin membatalkannya?')">
                    <button type="button" class="batal">Batal</button>
                </a>
            </div>
        </form>
        <div class="verifikasi-pemesanan">
            <form action="konfirmasi-pesanan.php?id_pemesanan=<?= $data['ID_order'] ?>" method="post">
                <input type="hidden" name="aksi" value="verifikasi">
                <input type="hidden" name="email_user" value="<?= htmlspecialchars($data['user_email']) ?>">
                <input type="hidden" name="verify_code" value="<?= $data['verify_token'] ?>">
                <input type="hidden" name="id_order" value="<?= $data['ID_order'] ?>">
                <input type="hidden" name="nama_wisata" value="<?= htmlspecialchars($data['nama_wisata']) ?>">
                <input type="hidden" name="total_harga" value="<?= htmlspecialchars($data['total_harga']) ?>">
                <button type="submit" name="verifikasi_pemesanan">Verifikasi Pemesanan</button>
            </form>
        </div>
        <div class="tombol kembali">
            <a href="javascript:history.back()">
                <button onclick="history.back()"><i class='bx bx-arrow-back'></i></button>
            </a>
        </div>

    </div>
    <footer class="footer">
        <div class="footer-container">
            <div class="footer-logo">
                <h2><span class="brand-explor">Explor</span><span class="brand-jatim">Jatim</span></h2>
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