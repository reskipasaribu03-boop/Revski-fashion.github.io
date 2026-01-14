<?php
include 'koneksi.php';

$id = $_GET['id'];

mysqli_query($koneksi, "UPDATE pembelian 
SET status_pembelian='selesai'
WHERE id_pembelian='$id'");

echo "<script>alert('Terima kasih! Pesanan selesai.');</script>";
echo "<script>location='riwayat.php';</script>";
?>
