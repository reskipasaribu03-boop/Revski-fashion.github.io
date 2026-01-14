<?php
session_start();
include 'koneksi.php';
if (!isset($_SESSION['pelanggan'])) {
    echo "<script>alert('Silahkan login terlebih dahulu!');location='login.php';</script>";
    exit();
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];
$ambil = $koneksi->query("SELECT * FROM pembelian WHERE id_pelanggan='$id_pelanggan' ORDER BY id_pembelian DESC");
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Pesanan Saya</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>
<?php include 'templates/navbar.php'; ?>
<div class="container mt-4">
  <h2>Pesanan Saya</h2>
  <table class="table table-bordered">
    <thead>
      <tr><th>ID</th><th>Tanggal</th><th>Total</th><th>Status</th><th>Aksi</th></tr>
    </thead>
    <tbody>
      <?php while($row = $ambil->fetch_assoc()): ?>
      <tr>
        <td><?= $row['id_pembelian']; ?></td>
        <td><?= $row['tanggal_pembelian']; ?></td>
        <td>Rp <?= number_format($row['total_pembelian']); ?></td>
        <td><b><?= htmlspecialchars($row['status_pembelian']); ?></b></td>
        <td>
          <a href="nota.php?id=<?= $row['id_pembelian']; ?>" class="btn btn-sm btn-info">Detail</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
</body>
</html>
