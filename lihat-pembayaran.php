<?php
session_start();
include 'koneksi.php';

if (!isset($_SESSION['pelanggan'])) {
    echo "<script>alert('Silahkan login');location='login.php';</script>";
    exit();
}

$id_pembelian = $_GET['id'];
$id_pelanggan_session = $_SESSION['pelanggan']['id_pelanggan'];

// Ambil data pembelian
$ambil = $koneksi->query("
    SELECT pembelian.*, pelanggan.nama_pelanggan 
    FROM pembelian 
    JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan
    WHERE pembelian.id_pembelian='$id_pembelian'
");
$detail = $ambil->fetch_assoc();

// Cek kepemilikan
if ($detail['id_pelanggan'] != $id_pelanggan_session) {
    echo "<script>alert('Tidak boleh melihat pembayaran orang lain!');location='riwayat.php';</script>";
    exit();
}

$ambilBayar = $koneksi->query("
    SELECT * FROM pembayaran
    WHERE id_pembelian='$id_pembelian'
");
$pembayaran = $ambilBayar->fetch_assoc();

?>
<!DOCTYPE html>
<html>
<head>
    <title>Lihat Pembayaran</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<div class="container">
    <h3>Detail Pembayaran</h3>
    <hr>

    <?php if (!$pembayaran): ?>
        <div class="alert alert-danger">
            Belum ada pembayaran untuk pesanan ini.
        </div>
    <?php else: ?>

        <table class="table table-bordered">
            <tr><th>Nama Pengirim</th><td><?= $pembayaran['nama']; ?></td></tr>
            <tr><th>Bank</th><td><?= $pembayaran['bank']; ?></td></tr>
            <tr><th>Jumlah</th><td>Rp <?= number_format($pembayaran['jumlah']); ?></td></tr>
            <tr><th>Tanggal</th><td><?= $pembayaran['tanggal']; ?></td></tr>
            <tr>
                <th>Bukti Transfer</th>
                <td>
                    <img src="bukti_pembayaran/<?= $pembayaran['bukti']; ?>" 
                         style="max-width:300px;">
                </td>
            </tr>
        </table>

    <?php endif; ?>

    <br>
    <a href="riwayat.php" class="btn btn-primary">Kembali ke Riwayat</a>

</div>

</body>
</html>
