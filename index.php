<?php
session_start();
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tokoku Fashion</title>
  <link rel="stylesheet" href="admin/assets/css/bootstrap.css">

  <style>
    .thumbnail {
      height: 420px;
      overflow: hidden;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    .thumbnail img {
      width: 100%;
      height: 230px;
      object-fit: cover;
      border-bottom: 1px solid #eee;
    }
    .thumbnail .caption h3 {
      font-size: 17px;
      height: 45px;
      overflow: hidden;
    }
    .thumbnail .caption h5 {
      margin-bottom: 12px;
      font-weight: bold;
    }
  </style>
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<!-- BANNER BESAR -->
<div class="container-fluid" style="margin: 0; padding: 0;">
  <div class="image">
  <img src="foto_produk/home.jpg" style="width:100%; height:600px; object-fit:cover;">
  </div>
</div>

<br><br>

<!-- DESKRIPSI TOKO -->
<div class="container">
  <h4 class="text-center"
      style="font-family:arial; padding:10px 0; font-style:italic; 
             line-height:30px; border-top:2px solid #000; border-bottom:2px solid #000;">
    Tokoku Fashion adalah pusat penjualan fashion pria & wanita yang menghadirkan gaya modern, 
    trendy, dan berkualitas tinggi. Kami menyediakan berbagai pilihan outfit untuk kebutuhan 
    sehari-hari, kerja, hingga acara spesial, dengan harga yang tetap ramah di kantong.
  </h4>

  <!-- JUDUL PRODUK -->
  <h2 style="width:100%; border-bottom:4px solid #000; margin-top:70px;">
    <b>Koleksi Fashion Terbaru</b>
  </h2>

  <!-- LIST PRODUK -->
  <div class="row">
    <?php
    $ambil = $koneksi->query("SELECT * FROM produk ORDER BY id_produk DESC");
    while ($produk = $ambil->fetch_assoc()):
    ?>
      <div class="col-md-3">
        <div class="thumbnail">
          <img src="foto_produk/<?= $produk['foto_produk']; ?>">

          <div class="caption">
            <h3><?= $produk['nama_produk']; ?></h3>
            <h5>Rp. <?= number_format($produk['harga_produk']); ?>,-</h5>

            <a href="beli.php?id=<?= $produk['id_produk']; ?>" class="btn btn-primary btn-sm btn-block">Beli</a>
            <a href="detail.php?id=<?= $produk['id_produk']; ?>" class="btn btn-default btn-sm btn-block">Detail</a>
          </div>

        </div>
      </div>
    <?php endwhile; ?>
  </div>

</div>

<br><br><br>

</body>
</html>
