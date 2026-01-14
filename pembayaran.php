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
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pembelian='$id_pembelian'");
$detail = $ambil->fetch_assoc();

// Cek apakah pemilik nota adalah pelanggan ini
if ($detail['id_pelanggan'] != $id_pelanggan_session) {
    echo "<script>alert('Tidak boleh melihat pembayaran orang lain!');location='riwayat.php';</script>";
    exit();
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Upload Pembayaran</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<div class="container">
    <h3>Konfirmasi Pembayaran</h3>
    <p>Total tagihan: <b>Rp <?= number_format($detail['total_pembelian']); ?></b></p>

    <form method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Penyetor</label>
            <input type="text" name="nama" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Bank</label>
            <input type="text" name="bank" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Jumlah Transfer</label>
            <input type="number" name="jumlah" min="1000" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Upload Bukti Pembayaran</label>
            <input type="file" name="bukti" class="form-control" required>
        </div>

        <button class="btn btn-primary" name="kirim">Kirim Pembayaran</button>
    </form>

</div>

<?php
// PROSES UPLOAD PEMBAYARAN
if (isset($_POST['kirim'])) {

    $nama   = $_POST['nama'];
    $bank   = $_POST['bank'];
    $jumlah = $_POST['jumlah'];

    // Simpan gambar
    $namafile = date("YmdHis") . "_" . $_FILES['bukti']['name'];
    $lokasi   = $_FILES['bukti']['tmp_name'];
    move_uploaded_file($lokasi, "bukti_pembayaran/$namafile");

    // Simpan ke database
    $koneksi->query("INSERT INTO pembayaran
        (id_pembelian, nama, bank, jumlah, tanggal, bukti)
        VALUES ('$id_pembelian', '$nama', '$bank', '$jumlah', NOW(), '$namafile')
    ");

    // Update status pesanan
    $koneksi->query("UPDATE pembelian 
                     SET status_pembelian='sudah kirim pembayaran'
                     WHERE id_pembelian='$id_pembelian'");

    echo "<script>alert('Terima kasih, bukti pembayaran sudah dikirim!');</script>";
    echo "<script>location='riwayat.php';</script>";
    exit();
}
?>

</body>
</html>
