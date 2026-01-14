<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['pelanggan'])){
    echo "<script>alert('Silahkan login terlebih dahulu');location='login.php';</script>";
    exit();
}

$id_pelanggan = $_SESSION['pelanggan']['id_pelanggan'];

$ambil = $koneksi->query("
    SELECT * FROM pembelian 
    WHERE id_pelanggan='$id_pelanggan' 
    ORDER BY id_pembelian DESC
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Riwayat Belanja</title>
<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<div class="container">
    <h3>Riwayat Belanja <?= $_SESSION['pelanggan']['nama_pelanggan']; ?></h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th><th>Tanggal</th><th>Status</th>
                <th>Total</th><th>Opsi</th>
            </tr>
        </thead>
        <tbody>

        <?php 
        $no = 1;
        if ($ambil->num_rows == 0): ?>
            <tr><td colspan="5">Belum ada riwayat belanja.</td></tr>
        <?php endif; ?>

        <?php while($p = $ambil->fetch_assoc()): ?>
        <tr>
            <td><?= $no++; ?></td>

            <td><?= date("d M Y", strtotime($p['tanggal_pembelian'])); ?></td>

            <td>
                <b><?= ucfirst($p['status_pembelian']); ?></b><br>

                <?php if (!empty($p['resi_pengiriman'])): ?>
                    Resi: <b><?= $p['resi_pengiriman']; ?></b>
                <?php endif; ?>
            </td>

            <td>Rp <?= number_format($p['total_pembelian']); ?></td>

            <td>
                <!-- LIHAT NOTA -->
                <a href="nota.php?id=<?= $p['id_pembelian']; ?>" class="btn btn-info btn-sm">
                    Nota
                </a>

                <!-- STATUS PENDING = Upload Pembayaran -->
                <?php if($p['status_pembelian'] == 'pending'): ?>
                    <a href="pembayaran.php?id=<?= $p['id_pembelian']; ?>" 
                       class="btn btn-success btn-sm">
                        Upload Pembayaran
                    </a>

                <!-- Jika sudah kirim pembayaran, lihat bukti -->
                <?php elseif($p['status_pembelian'] == 'sudah kirim pembayaran'): ?>
                    <a href="lihat-pembayaran.php?id=<?= $p['id_pembelian']; ?>" 
                       class="btn btn-warning btn-sm">
                        Lihat Pembayaran
                    </a>

                <!-- Status dibayar, dikemas → tombol lihat bukti -->
                <?php elseif($p['status_pembelian'] == 'dibayar' OR 
                              $p['status_pembelian'] == 'dikemas'): ?>
                    <a href="lihat-pembayaran.php?id=<?= $p['id_pembelian']; ?>" 
                       class="btn btn-warning btn-sm">
                        Lihat Bukti Pembayaran
                    </a>

                <!-- Jika dikirim → lihat pembayaran + lihat nota -->
                <?php elseif($p['status_pembelian'] == 'dikirim'): ?>
                    <a href="lihat-pembayaran.php?id=<?= $p['id_pembelian']; ?>" 
                       class="btn btn-warning btn-sm">
                        Lihat Pembayaran
                    </a>

                <?php elseif($p['status_pembelian'] == 'selesai'): ?>
                    <span class="btn btn-success btn-sm disabled">Selesai</span>

                <?php elseif($p['status_pembelian'] == 'batal'): ?>
                    <span class="btn btn-danger btn-sm disabled">Batal</span>

                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>

        </tbody>
    </table>

</div>
</body>
</html>
