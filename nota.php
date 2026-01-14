<?php
session_start();
include 'koneksi.php';

// Ambil detail pembelian
$ambil = $koneksi->query("
    SELECT * FROM pembelian 
    JOIN pelanggan ON pembelian.id_pelanggan = pelanggan.id_pelanggan 
    WHERE pembelian.id_pembelian = '$_GET[id]'
");
$detail = $ambil->fetch_assoc();

// Cek apakah nota milik pelanggan yg login
$id_pelanggan_beli = $detail['id_pelanggan'];
$id_pelanggan_login = $_SESSION['pelanggan']['id_pelanggan'];

if ($id_pelanggan_beli != $id_pelanggan_login) {
    echo "<script>alert('Akses ditolak');location='riwayat.php';</script>";
    exit();
}

// Jika pelanggan konfirmasi pesanan selesai
if (isset($_POST['konfirmasi_terima'])) {

    $koneksi->query("
        UPDATE pembelian 
        SET status_pembelian='selesai' 
        WHERE id_pembelian='$_GET[id]'
    ");

    echo "<script>alert('Terima kasih, pesanan selesai!');</script>";
    echo "<script>location='nota.php?id=$_GET[id]';</script>";
    exit();
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Nota Pembelian</title>
    <link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<div class="container">
    <h2>Nota Pembelian</h2>
    <hr>

    <!-- STATUS PESANAN -->
    <div class="alert alert-info">
        <h4>Status Pesanan: <b><?= strtoupper($detail['status_pembelian']); ?></b></h4>

        <?php if (!empty($detail['resi_pengiriman'])): ?>
            <p>Nomor Resi: <b><?= $detail['resi_pengiriman']; ?></b></p>
        <?php endif; ?>

        <p>
        <?php
        $s = $detail['status_pembelian'];
        if ($s == 'pending') echo "Menunggu pembayaran dari pembeli.";
        elseif ($s == 'sudah kirim pembayaran') echo "Pembayaran telah dikirim, menunggu verifikasi admin.";
        elseif ($s == 'dibayar') echo "Pembayaran telah diverifikasi. Pesanan segera dikemas.";
        elseif ($s == 'dikemas') echo "Pesanan sedang dikemas oleh penjual.";
        elseif ($s == 'dikirim') echo "Pesanan sedang dalam perjalanan.";
        elseif ($s == 'selesai') echo "Pesanan telah selesai. Terima kasih telah berbelanja!";
        elseif ($s == 'batal') echo "Pesanan dibatalkan.";
        ?>
        </p>
    </div>


    <!-- DATA PEMBELIAN -->
    <div class="row" style="margin-bottom: 15px;">

        <div class="col-md-4">
            <h4>Pembelian</h4>
            No. Pembelian: <b><?= $detail['id_pembelian']; ?></b><br>
            Tanggal: <?= date("d M Y", strtotime($detail['tanggal_pembelian'])); ?><br>
            Total: <b>Rp <?= number_format($detail['total_pembelian']); ?></b>
        </div>

        <div class="col-md-4">
            <h4>Pelanggan</h4>
            <b><?= $detail['nama_pelanggan']; ?></b><br>
            Telp: <?= $detail['telepon_pelanggan']; ?><br>
            Email: <?= $detail['email_pelanggan']; ?>
        </div>

        <div class="col-md-4">
            <h4>Pengiriman</h4>
            <?= $detail['tipe']; ?> <?= $detail['distrik']; ?> <?= $detail['provinsi']; ?><br>
            Ekspedisi: <?= $detail['ekspedisi']; ?> (<?= $detail['paket']; ?>)<br>
            Estimasi: <?= $detail['estimasi']; ?><br>
            Ongkir: Rp <?= number_format($detail['ongkir']); ?><br>
            Alamat: <?= $detail['alamat_pengiriman']; ?>
        </div>

    </div>


    <!-- TABEL PRODUK -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th><th>Nama Produk</th><th>Harga</th>
                <th>Berat</th><th>Jumlah</th><th>Subberat</th><th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $no = 1;
        $produk = $koneksi->query("SELECT * FROM pembelian_produk WHERE id_pembelian='$_GET[id]'");
        while ($p = $produk->fetch_assoc()):
        ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $p['nama']; ?></td>
            <td>Rp <?= number_format($p['harga']); ?></td>
            <td><?= $p['berat']; ?> gr</td>
            <td><?= $p['jumlah']; ?></td>
            <td><?= $p['subberat']; ?> gr</td>
            <td>Rp <?= number_format($p['subharga']); ?></td>
        </tr>
        <?php endwhile; ?>
        </tbody>
    </table>


    <!-- INFORMASI PEMBAYARAN -->
    <?php if ($detail['status_pembelian'] == 'pending'): ?>
        <div class="alert alert-warning">
            <b>Lakukan Pembayaran</b><br>
            Jumlah: <b>Rp <?= number_format($detail['total_pembelian']); ?></b><br>
            Kirim ke:<br>
            <b>MANDIRI 123-456-789 a/n Asal Koding by Reski</b><br><br>
            Setelah transfer, upload bukti pembayaran di <b>Riwayat Belanja</b>.
        </div>
    <?php endif; ?>


    <!-- TOMBOL TERIMA BARANG -->
    <?php if ($detail['status_pembelian'] == 'dikirim'): ?>
        <form method="post">
            <button class="btn btn-success" name="konfirmasi_terima"
                onclick="return confirm('Yakin barang sudah diterima?');">
                Saya Sudah Terima Barang
            </button>
        </form>
    <?php endif; ?>

</div>

</body>
</html>
