<?php
include 'koneksi.php';

$keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

$semuadata = array();
$ambil = $koneksi->query("SELECT * FROM produk 
                          WHERE nama_produk LIKE '%$keyword%' 
                          OR deskripsi_produk LIKE '%$keyword%'");

while($pecah = $ambil->fetch_assoc()) {
    $semuadata[] = $pecah;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencarian Produk</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">

    <!-- CSS agar tampilan rapi -->
    <style>
        .thumbnail img {
            width: 100%;
            height: 200px;
            object-fit: cover; /* Biar semua gambar terlihat rapi */
        }
        .thumbnail {
            min-height: 380px; /* Mencegah card naik turun */
        }
        .caption h3 {
            font-size: 18px;
            min-height: 45px; /* Biar judul rapi */
        }
    </style>

</head>
<body>

<?php include 'templates/navbar.php'; ?>

<section class="content">
    <div class="container">

        <h3>Hasil Pencarian: <strong><?= htmlspecialchars($keyword); ?></strong></h3>
        <hr>

        <!-- Jika hasil pencarian kosong -->
        <?php if(empty($semuadata)): ?>
            <div class="alert alert-danger">
                Produk <strong><?= htmlspecialchars($keyword); ?></strong> tidak ditemukan.
            </div>

        <?php else: ?>
            <!-- Hanya tampilkan grid jika ada produk -->
            <div class="row">

                <?php foreach($semuadata as $produk): ?>
                <div class="col-md-3 col-sm-6">
                    <div class="thumbnail">
                        <img src="foto_produk/<?= $produk['foto_produk']; ?>" alt="<?= $produk['nama_produk']; ?>">
                        <div class="caption">
                            <h3><?= $produk['nama_produk']; ?></h3>
                            <h5>Rp <?= number_format($produk['harga_produk']); ?>,-</h5>

                            <a href="beli.php?id=<?= $produk['id_produk']; ?>" class="btn btn-primary btn-sm">
                                Beli
                            </a>
                            <a href="detail.php?id=<?= $produk['id_produk']; ?>" class="btn btn-default btn-sm">
                                Detail
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>

            </div>
        <?php endif; ?>

    </div>
</section>

</body>
</html>
