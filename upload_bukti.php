<?php
include 'koneksi.php';

$id_pembelian = $_POST['id_pembelian'];
$nama = $_POST['nama'];
$bank = $_POST['bank'];
$jumlah = $_POST['jumlah'];

// Upload file bukti transfer
$nama_file = date("YmdHis") . $_FILES['bukti']['name'];
$lokasi = $_FILES['bukti']['tmp_name'];
move_uploaded_file($lokasi, "bukti_pembayaran/" . $nama_file);

// Simpan ke tabel pembayaran
mysqli_query($koneksi, "INSERT INTO pembayaran 
(id_pembelian, nama, bank, jumlah, tanggal, bukti, status)
VALUES ('$id_pembelian', '$nama', '$bank', '$jumlah', CURDATE(), '$nama_file', 'pending')");

// Update status pembelian
mysqli_query($koneksi, "UPDATE pembelian 
SET status_pembelian='sudah kirim pembayaran' 
WHERE id_pembelian='$id_pembelian'");

echo "<script>alert('Terima kasih! Bukti pembayaran telah dikirim');</script>";
echo "<script>location='riwayat.php';</script>";
?>
