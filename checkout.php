<?php
session_start();
include 'koneksi.php';

// Pastikan user login
if (!isset($_SESSION["pelanggan"])) {
    echo "<script>alert('Silahkan login terlebih dahulu!');</script>";
    echo "<script>location='login.php';</script>";
    exit();
}

// Pastikan keranjang tidak kosong
if (empty($_SESSION["keranjang"]) OR !isset($_SESSION["keranjang"])) {
    echo "<script>alert('Keranjang kosong!');</script>";
    echo "<script>location='index.php';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Checkout</title>
<link rel="stylesheet" href="admin/assets/css/bootstrap.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<?php include 'templates/navbar.php'; ?>

<section class="content">
<div class="container">
<h1>Checkout</h1>

<?php
$no = 1;
$totalberat = 0;
$totalbelanja = 0;
?>

<table class="table table-bordered">
<thead>
<tr>
<th>No</th>
<th>Produk</th>
<th>Harga</th>
<th>Jumlah</th>
<th>Ukuran</th>
<th>Subharga</th>
</tr>
</thead>
<tbody>

<?php foreach ($_SESSION["keranjang"] as $id_produk => $item):

    if (!is_array($item)) {
        $item = ["jumlah" => $item, "ukuran" => "-"];
    }

    $jumlah = $item["jumlah"];
    $ukuran = $item["ukuran"];

    $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
    $produk = $ambil->fetch_assoc();

    $subharga = $produk["harga_produk"] * $jumlah;
    $subberat = $produk["berat_produk"] * $jumlah;

    $totalbelanja += $subharga;
    $totalberat += $subberat;
?>

<tr>
<td><?= $no++; ?></td>
<td><?= $produk["nama_produk"] ?></td>
<td>Rp <?= number_format($produk["harga_produk"]) ?></td>
<td><?= $jumlah ?></td>
<td><?= $ukuran ?></td>
<td>Rp <?= number_format($subharga) ?></td>
</tr>

<?php endforeach; ?>

</tbody>

<tfoot>
<tr>
<th colspan="5">Total Belanja</th>
<th>Rp <?= number_format($totalbelanja) ?></th>
</tr>
</tfoot>
</table>

<form method="post">

<div class="form-group">
<label>Alamat Lengkap</label>
<textarea class="form-control" name="alamat_pengiriman" required></textarea>
</div>

<div class="row">

<!-- PROVINSI -->
<div class="col-md-3">
<label>Provinsi</label>
<select class="form-control" name="nama_provinsi" id="provinsiSelect" required>
<option value="">-- Pilih Provinsi --</option>
<option value="Jawa Barat">Jawa Barat</option>
<option value="Jawa Tengah">Jawa Tengah</option>
<option value="Jawa Timur">Jawa Timur</option>
<option value="DKI Jakarta">DKI Jakarta</option>
<option value="Banten">Banten</option>
<option value="Sumatera Utara">Sumatera Utara</option>
<option value="Sumatera Barat">Sumatera Barat</option>
</select>
</div>

<!-- KOTA (BERUBAH OTOMATIS) -->
<div class="col-md-3">
<label>Kota</label>
<select class="form-control" name="nama_kota" id="kotaSelect" required>
<option value="">-- Pilih Kota --</option>
</select>
</div>

<!-- EKSPEDISI -->
<div class="col-md-3">
<label>Ekspedisi</label>
<select class="form-control" name="nama_ekspedisi" required>
<option value="">-- Pilih Ekspedisi --</option>
<option value="JNE">JNE</option>
<option value="J&T">J&T</option>
<option value="SICEPAT">SICEPAT</option>
</select>
</div>

<!-- PAKET -->
<div class="col-md-3">
<label>Paket</label>
<select class="form-control" name="nama_paket" id="paketSelect" required>
<option value="">-- Pilih Paket --</option>
<option value="REG">REG (3-5 Hari)</option>
<option value="EKONOMI">EKONOMI (5-7 Hari)</option>
<option value="YES">YES (1 Hari)</option>
</select>
</div>

</div>

<input type="hidden" name="ongkir">
<input type="hidden" name="estimasi">
<input type="hidden" name="total_berat" value="<?= $totalberat ?>">

<br>
<button name="checkout" class="btn btn-primary">Checkout</button>

</form>

<?php
// ========== PROSES CHECKOUT ==========
if (isset($_POST["checkout"])) {

    $id_pelanggan = $_SESSION["pelanggan"]["id_pelanggan"];
    $tanggal = date("Y-m-d H:i:s");

    $alamat = $_POST["alamat_pengiriman"];
    $provinsi = $_POST["nama_provinsi"];
    $kota = $_POST["nama_kota"];
    $ekspedisi = $_POST["nama_ekspedisi"];
    $paket = $_POST["nama_paket"];

    $ongkir = (int)$_POST["ongkir"];
    $estimasi = $_POST["estimasi"];

    $total_berat = (int)$_POST["total_berat"];
    $total_pembelian = $totalbelanja + $ongkir;

    // INSERT pembelian (sesuai database kamu)
    $koneksi->query("INSERT INTO pembelian
        (id_pelanggan, tanggal_pembelian, total_pembelian, alamat_pengiriman,
         totalberat, provinsi, distrik, ekspedisi, paket, ongkir, estimasi)
        VALUES ('$id_pelanggan','$tanggal','$total_pembelian','$alamat',
                '$total_berat','$provinsi','$kota','$ekspedisi',
                '$paket','$ongkir','$estimasi')");

    $id_pembelian_baru = $koneksi->insert_id;

    // INSERT pembelian produk
    foreach ($_SESSION["keranjang"] as $id_produk => $item) {

        if (!is_array($item)) {
            $item = ["jumlah" => $item, "ukuran" => "-"];
        }

        $jumlah = $item["jumlah"];
        $ukuran = $item["ukuran"];

        $ambil = $koneksi->query("SELECT * FROM produk WHERE id_produk='$id_produk'");
        $produk = $ambil->fetch_assoc();

        $nama = $produk["nama_produk"];
        $harga = $produk["harga_produk"];
        $berat = $produk["berat_produk"];

        $subharga = $harga * $jumlah;
        $subberat = $berat * $jumlah;

        $koneksi->query("INSERT INTO pembelian_produk
            (id_pembelian,id_produk,jumlah,ukuran,nama,harga,berat,subberat,subharga)
            VALUES ('$id_pembelian_baru','$id_produk','$jumlah','$ukuran',
            '$nama','$harga','$berat','$subberat','$subharga')");

        // Kurangi stok
        $koneksi->query("UPDATE produk SET stok_produk = stok_produk - $jumlah 
                         WHERE id_produk='$id_produk'");
    }

    unset($_SESSION["keranjang"]);

    echo "<script>alert('Pembelian sukses!');</script>";
    echo "<script>location='nota.php?id=$id_pembelian_baru';</script>";
    exit();
}
?>

</div>
</section>

<script>
// DATA KOTA PER PROVINSI
const dataKota = {

    "Jawa Barat": [
        {nama:"Bandung", ongkir:20000},
        {nama:"Cimahi", ongkir:22000},
        {nama:"Bogor", ongkir:18000},
        {nama:"Depok", ongkir:17000},
        {nama:"Cianjur", ongkir:23000}
    ],

    "Jawa Tengah": [
        {nama:"Semarang", ongkir:30000},
        {nama:"Solo", ongkir:32000},
        {nama:"Magelang", ongkir:35000}
    ],

    "Jawa Timur": [
        {nama:"Surabaya", ongkir:35000},
        {nama:"Malang", ongkir:36000},
        {nama:"Blitar", ongkir:38000}
    ],

    "DKI Jakarta": [
        {nama:"Jakarta Selatan", ongkir:15000},
        {nama:"Jakarta Barat", ongkir:15000},
        {nama:"Jakarta Timur", ongkir:15000}
    ],

    "Banten": [
        {nama:"Tangerang", ongkir:20000},
        {nama:"Tangerang Selatan", ongkir:17000},
        {nama:"Serang", ongkir:22000}
    ],

    "Sumatera Utara": [
        {nama:"Medan", ongkir:10000},
        {nama:"Binjai", ongkir:12000},
        {nama:"Deli Serdang", ongkir:15000},
        {nama:"Tebing Tinggi", ongkir:18000}
    ],

    "Sumatera Barat": [
        {nama:"Padang", ongkir:20000},
        {nama:"Bukittinggi", ongkir:23000},
        {nama:"Payakumbuh", ongkir:24000}
    ]

};

// FILTER KOTA BERDASARKAN PROVINSI
$(document).on("change", "#provinsiSelect", function () {
    const prov = $(this).val();
    const kotaSelect = $("#kotaSelect");

    kotaSelect.html('<option value="">-- Pilih Kota --</option>');

    if (dataKota[prov]) {
        dataKota[prov].forEach(function (k) {
            kotaSelect.append(
                `<option value="${k.nama}" data-ongkir="${k.ongkir}">${k.nama} (Rp ${k.ongkir.toLocaleString()})</option>`
            );
        });
    }
});

// SET ONGKIR OTOMATIS
$(document).on("change", "#kotaSelect", function () {
    let ong = $(this).find("option:selected").data("ongkir");
    $("input[name=ongkir]").val(ong);
});

// SET ESTIMASI OTOMATIS
$(document).on("change", "#paketSelect", function () {
    let paket = $(this).val();
    let est = (paket === "YES") ? "1 Hari" :
              (paket === "EKONOMI") ? "5-7 Hari" : "3-5 Hari";

    $("input[name=estimasi]").val(est);
});
</script>

</body>
</html>
