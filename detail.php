<?php
session_start();

// Koneksi ke database
include 'koneksi.php';

// Mendapatkan id_produk dari url
$id_produk = $_GET['id'];

// Ambil data produk
$ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
$detail = $ambil->fetch_assoc();

// Ambil data ukuran berdasarkan produk
$ukuran = $koneksi->query("SELECT * FROM produk_ukuran WHERE id_produk='$id_produk'");

// Jika tombol beli di klik
if(isset($_POST['beli'])){
    $jumlah = $_POST['jumlah'];
    $pilih_ukuran = $_POST['ukuran'];

    // Simpan ke session
    $_SESSION['keranjang'][$id_produk] = [
        'jumlah' => $jumlah,
        'ukuran' => $pilih_ukuran
    ];

    echo "<div class='alert alert-success'>Produk telah masuk ke keranjang</div>";
    echo "<meta http-equiv='refresh' content='1;url=keranjang.php'>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Detail Produk</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<section class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <img src="foto_produk/<?= $detail['foto_produk']; ?>" class="img-responsive">
      </div>
      <div class="col-md-6">
        <h2><?= $detail['nama_produk']; ?></h2>
        <h4>Rp. <?= number_format($detail['harga_produk']); ?>,-</h4>

        <form method="post">

            <div class="form-group">
              <label>Pilih Ukuran</label>
              <select name="ukuran" class="form-control" required>
                <option value="">-- Pilih Ukuran --</option>
                <?php while($u = $ukuran->fetch_assoc()): ?>
                    <option value="<?= $u['ukuran']; ?>">
                        <?= $u['ukuran']; ?> (stok: <?= $u['stok']; ?>)
                    </option>
                <?php endwhile; ?>
              </select>
            </div>

            <div class="form-group">
                <label>Jumlah</label>
                <input type="number" min="1" class="form-control" name="jumlah" required>
            </div>

            <button class="btn btn-primary" name="beli">Beli</button>

        </form>

        <br>
        <p><?= $detail['deskripsi_produk']; ?></p>
      </div>
    </div>
  </div>
</section>

</body>
</html>
