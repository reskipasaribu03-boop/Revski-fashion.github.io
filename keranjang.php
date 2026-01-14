<?php
session_start();

// Koneksi ke database
include 'koneksi.php';

// Jika keranjang kosong
if (empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"])) {
  echo "<script>alert('Keranjang kosong, silahkan pilih produk!');</script>";
  echo "<script>location='index.php';</script>";
  exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Keranjang Belanja</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<section class="content">
  <div class="container">
    <h1>Keranjang Belanja</h1>

    <table class="table table-bordered">
      <thead>
        <tr>
          <th>No</th>
          <th>Produk</th>
          <th>Harga</th>
          <th>Jumlah</th>
          <th>Ukuran</th>
          <th>Subharga</th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>

        <?php $no = 1; ?>
        <?php foreach ($_SESSION['keranjang'] as $id_produk => $item): ?>

          <?php
          // Jika keranjang lama: hanya jumlah (angka)
          if (is_numeric($item)) {
              $jumlah = $item;
              $ukuran = "-";
          } 
          // Jika keranjang baru: jumlah + ukuran
          else {
              $jumlah = $item["jumlah"];
              $ukuran = $item["ukuran"];
          }

          // Ambil data produk
          $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
          $pecah = $ambil->fetch_assoc();

          $subharga = $pecah['harga_produk'] * $jumlah;
          ?>

          <tr>
            <td><?= $no++; ?></td>
            <td><?= $pecah['nama_produk']; ?></td>
            <td>Rp. <?= number_format($pecah['harga_produk']); ?>,-</td>
            <td><?= $jumlah; ?></td>
            <td><?= $ukuran; ?></td>
            <td>Rp. <?= number_format($subharga); ?>,-</td>
            <td>
              <a href="hapuskeranjang.php?id=<?= $id_produk; ?>" class="btn btn-danger btn-xs">Hapus</a>
            </td>
          </tr>

        <?php endforeach; ?>

      </tbody>
    </table>

    <a href="index.php" class="btn btn-default">Lanjutkan Belanja</a>
    <a href="checkout.php" class="btn btn-primary">Checkout</a>

  </div>
</section>

</body>
</html>
