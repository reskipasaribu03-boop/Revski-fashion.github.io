-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 16, 2025 at 06:23 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_tokoonline`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id_admin` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id_admin`, `username`, `password`, `nama_lengkap`) VALUES
(1, 'reski', '1234', 'Reski Talenta');

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int(5) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(2001, 'Atasan batik wanita'),
(2002, 'Atasan batik wanita'),
(2003, 'Atasan batik wanita'),
(2004, 'Atasan batik wanita'),
(2005, 'kemeja wanita'),
(2006, 'kemeja wanita\r\n'),
(2007, 'kemeja wanita'),
(2008, 'kemeja wanita'),
(2009, 'kaos pria'),
(2010, 'kaos pria'),
(2011, 'kaos pria'),
(2012, 'kaos pria'),
(2013, 'kemeja pria'),
(2015, 'kemeja pria'),
(2016, 'kemeja pria'),
(2017, 'kemeja pria'),
(2018, 'celana wanita'),
(2019, 'celana wanita'),
(2020, 'celana wanita'),
(2021, 'celana wanita'),
(2022, 'celana pria'),
(2023, 'celana pria'),
(2024, 'celana pria'),
(2025, 'celana pria');

-- --------------------------------------------------------

--
-- Table structure for table `ongkir`
--

CREATE TABLE `ongkir` (
  `id_ongkir` int(11) NOT NULL,
  `nama_kota` varchar(100) NOT NULL,
  `tarif` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pelanggan`
--

CREATE TABLE `pelanggan` (
  `id_pelanggan` int(11) NOT NULL,
  `email_pelanggan` varchar(100) NOT NULL,
  `password_pelanggan` varchar(50) NOT NULL,
  `nama_pelanggan` varchar(100) NOT NULL,
  `telepon_pelanggan` varchar(100) NOT NULL,
  `alamat_pelanggan` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pelanggan`
--

INSERT INTO `pelanggan` (`id_pelanggan`, `email_pelanggan`, `password_pelanggan`, `nama_pelanggan`, `telepon_pelanggan`, `alamat_pelanggan`) VALUES
(7, 'yohana@gmail.com', 'yohana', 'yohana', '082343454688', 'jl bakti'),
(8, 'andis@gmail.com', 'andi', 'Andi Setiawan', '083434758997', 'Jl Mengkudu 5'),
(9, 'rania@gmail.com', 'rania', 'rania', '08283647699', 'Jl Garu VIII');

-- --------------------------------------------------------

--
-- Table structure for table `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id_pembayaran` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `bank` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `bukti` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembayaran`
--

INSERT INTO `pembayaran` (`id_pembayaran`, `id_pembelian`, `nama`, `bank`, `jumlah`, `tanggal`, `bukti`, `status`) VALUES
(15, 28, 'rania', 'BCA', 130000, '2025-12-01', '20251201053233_bs.jpg', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian`
--

CREATE TABLE `pembelian` (
  `id_pembelian` int(11) NOT NULL,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `alamat_pengiriman` text NOT NULL,
  `status_pembelian` enum('pending','sudah kirim pembayaran','dibayar','dikemas','dikirim','selesai','batal') NOT NULL DEFAULT 'pending',
  `resi_pengiriman` varchar(50) NOT NULL,
  `totalberat` int(11) NOT NULL,
  `provinsi` varchar(255) NOT NULL,
  `distrik` varchar(255) NOT NULL,
  `tipe` varchar(255) NOT NULL,
  `kodepos` varchar(255) NOT NULL,
  `ekspedisi` varchar(255) NOT NULL,
  `paket` varchar(255) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `estimasi` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembelian`
--

INSERT INTO `pembelian` (`id_pembelian`, `id_pelanggan`, `tanggal_pembelian`, `total_pembelian`, `alamat_pengiriman`, `status_pembelian`, `resi_pengiriman`, `totalberat`, `provinsi`, `distrik`, `tipe`, `kodepos`, `ekspedisi`, `paket`, `ongkir`, `estimasi`) VALUES
(28, 9, '2025-12-01', 130000, 'Jl Swama', 'sudah kirim pembayaran', '', 1, 'Jawa Barat', 'Bandung', '', '', 'JNE', 'REG', 20000, '3-5 Hari');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_backup`
--

CREATE TABLE `pembelian_backup` (
  `id_pembelian` int(11) NOT NULL DEFAULT 0,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `alamat_pengiriman` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_pembelian` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'pending',
  `resi_pengiriman` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `totalberat` int(11) NOT NULL,
  `provinsi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `distrik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipe` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kodepos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ekspedisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paket` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ongkir` int(11) NOT NULL,
  `estimasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_backup`
--

INSERT INTO `pembelian_backup` (`id_pembelian`, `id_pelanggan`, `tanggal_pembelian`, `total_pembelian`, `alamat_pengiriman`, `status_pembelian`, `resi_pengiriman`, `totalberat`, `provinsi`, `distrik`, `tipe`, `kodepos`, `ekspedisi`, `paket`, `ongkir`, `estimasi`) VALUES
(20, 7, '2025-11-24', 335000, 'Jl Garu VIII No. 22', 'dibayar', '1092384576', 0, 'Sumatera Utara', 'Medan', '', '', 'JNE', 'EKONOMI', 10000, '5–7 Hari');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_before_fix`
--

CREATE TABLE `pembelian_before_fix` (
  `id_pembelian` int(11) NOT NULL DEFAULT 0,
  `id_pelanggan` int(11) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `total_pembelian` int(11) NOT NULL,
  `alamat_pengiriman` text CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `status_pembelian` varchar(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'pending',
  `resi_pengiriman` varchar(50) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `totalberat` int(11) NOT NULL,
  `provinsi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `distrik` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `tipe` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `kodepos` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ekspedisi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `paket` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL,
  `ongkir` int(11) NOT NULL,
  `estimasi` varchar(255) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `pembelian_before_fix`
--

INSERT INTO `pembelian_before_fix` (`id_pembelian`, `id_pelanggan`, `tanggal_pembelian`, `total_pembelian`, `alamat_pengiriman`, `status_pembelian`, `resi_pengiriman`, `totalberat`, `provinsi`, `distrik`, `tipe`, `kodepos`, `ekspedisi`, `paket`, `ongkir`, `estimasi`) VALUES
(20, 7, '2025-11-24', 335000, 'Jl Garu VIII No. 22', 'barang dikirim', '', 0, 'Sumatera Utara', 'Medan', '', '', 'JNE', 'EKONOMI', 10000, '5–7 Hari');

-- --------------------------------------------------------

--
-- Table structure for table `pembelian_produk`
--

CREATE TABLE `pembelian_produk` (
  `id_pembelian_produk` int(11) NOT NULL,
  `id_pembelian` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `ukuran` varchar(10) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `harga` int(11) NOT NULL,
  `berat` int(11) NOT NULL,
  `subberat` int(11) NOT NULL,
  `subharga` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `pembelian_produk`
--

INSERT INTO `pembelian_produk` (`id_pembelian_produk`, `id_pembelian`, `id_produk`, `jumlah`, `ukuran`, `nama`, `harga`, `berat`, `subberat`, `subharga`) VALUES
(39, 28, 107, 1, '-', 'kemeja lengan panjang pink wanita', 110000, 1, 1, 110000);

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id_produk` int(11) NOT NULL,
  `id_kategori` int(5) NOT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `harga_produk` int(11) NOT NULL,
  `berat_produk` int(11) NOT NULL,
  `foto_produk` varchar(100) NOT NULL,
  `deskripsi_produk` text NOT NULL,
  `stok_produk` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id_produk`, `id_kategori`, `nama_produk`, `harga_produk`, `berat_produk`, `foto_produk`, `deskripsi_produk`, `stok_produk`) VALUES
(101, 2001, 'Batik wanita elegan', 175000, 1, 'baju1.jpg', 'ini adalah baju batik elegan wanita lokal yang dibuat dengan bahan-bahan berkualitas', 77),
(102, 2002, 'batik wanita', 150000, 0, 'baju2.png', 'batik wanita', 29),
(103, 2003, 'batik merah wanita', 199999, 1, 'baju3.jpg', 'batik wanita dengan warna merah', 50),
(104, 2004, 'batik coklat wanita lengan panjang', 155000, 1, 'batik4.jpg', 'baju wanita lengan panjang acara formal', 21),
(105, 2005, 'kemeja wanita lengan panjang', 89000, 1, 'kemeja1.jpeg', 'kemeja lengan panjang wanita', 100),
(106, 2006, 'kemeja wanita lengan panjang', 78000, 1, 'kemeja2.jpeg', 'kemeja wanita lengan panjang keren', 20),
(107, 2007, 'kemeja lengan panjang pink wanita', 110000, 1, 'kemeja3.jpeg', 'kemeja pink wanita', 31),
(108, 2008, 'kemeja biru wanita', 105000, 1, 'kemeja4.jpeg', 'kemeja biru wanita lengan panjang', 25),
(109, 2009, 'kaos polos pria berwarna biru', 100000, 1, 'kaos1.jpeg', 'kaos polos pria ', 40),
(110, 2010, 'kaos polos pria abu-abu', 89000, 1, 'kaos2.jpeg', 'kaos pria polos', 25),
(111, 2011, 'kaos pria lengan pendek', 70000, 1, 'kaos3.jpeg', 'kaos polos pria lengan pendek coksu', 55),
(112, 2012, 'kaos pria ', 59000, 1, 'kaos4.jpg', 'kaos pria', 12),
(113, 2013, 'kemeja pria berwarna biru', 60000, 1, '1.jpeg', 'kemeja pria', 4),
(115, 2015, 'kemeja hitam pria', 155000, 1, '2.jpeg', 'kema hitam pria', 20),
(116, 2016, 'hijau kemeja pria lengan panjang', 80000, 1, '3.jpeg', 'kemeja pria wrna hijau lengan panjang', 15),
(117, 2017, 'kemeja pria kotak kotak merah', 65000, 1, '4.jpeg', 'kemeja pria kotak kotak merah', 30),
(118, 2018, 'Ankle Pants ', 160000, 1, 'celana1.jpeg', 'Celana Wanita Ankle Pants dibuat oleh brand Cottonary', 24),
(119, 2019, 'Barrel Pants', 224000, 1, 'celana2.jpeg', 'Celana wanita barrel pants dibuat oleh brand Stuca', 25),
(120, 2020, 'Celana motif stripe', 140000, 1, 'celana3.jpeg', 'celana wanita motif stripe oleh brand Myrubylicious', 20),
(121, 2021, 'Celana kerja wanita bermotif tartan', 215000, 1, 'celana4.jpeg', 'Celana kerja bermotif tartan 3Mongkis', 30),
(122, 2022, 'Morrowsky Cargo Pants', 177000, 1, 'celana5.jpeg', 'Morrowsky Cargo Pants berasal dari bahan-bahan premium yang tentu nyaman untuk pengguna.', 30),
(123, 2023, 'Cargo Pants Fairgoods', 93000, 1, 'celana6.jpeg', 'Celana yang dibuat dari material cotton twill ini cukup keren dan cocok bagi kamu yang ingin tampil stylist. Untuk mendapatkan celana ini, kamu hanya perlu mengeluarkan uang Rp93 ribuan saja.\r\n\r\nCelana cargo buatan Fairgoods ini memiliki desain yang lebih slim fit. Cocok dipadukan dengan berbagai macam jaket atau t-shirt yang kamu punya. Fairgoods menyediakan berbagai warna untuk celana ini mulai dari hitam, abu-abu, hijau army, hingga khaki.', 35),
(124, 2024, 'Cargo Gizmo', 150000, 1, 'celana7.jpeg', 'Cargo Gizmo dibuat dengan bahan yang menggunakan cotton twill premium.', 45),
(125, 2025, 'Pluviophile Long Cargo Pants Jeans', 170000, 1, 'celana8.jpeg', 'Pluviophile Long Cargo Pants Jeans : celana cargo ini terbuat dari bahan kain denim.', 21);

-- --------------------------------------------------------

--
-- Table structure for table `produk_foto`
--

CREATE TABLE `produk_foto` (
  `id_produk_foto` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `nama_produk_foto` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `produk_foto`
--

INSERT INTO `produk_foto` (`id_produk_foto`, `id_produk`, `nama_produk_foto`) VALUES
(1101, 101, 'baju1.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `produk_ukuran`
--

CREATE TABLE `produk_ukuran` (
  `id_ukuran` int(11) NOT NULL,
  `id_produk` int(11) NOT NULL,
  `ukuran` varchar(20) NOT NULL,
  `stok` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `produk_ukuran`
--

INSERT INTO `produk_ukuran` (`id_ukuran`, `id_produk`, `ukuran`, `stok`) VALUES
(1, 101, 'S', 10),
(2, 101, 'M', 25),
(3, 101, 'L', 30),
(4, 101, 'XL', 15),
(5, 118, '28', 10),
(6, 118, '29', 15),
(7, 118, '30', 20),
(8, 102, 'S', 10),
(9, 102, 'M', 15),
(10, 102, 'L', 20),
(11, 102, 'XL', 12),
(12, 103, 'S', 10),
(13, 103, 'M', 15),
(14, 103, 'L', 20),
(15, 103, 'XL', 12),
(16, 104, 'S', 10),
(17, 104, 'M', 15),
(18, 104, 'L', 20),
(19, 104, 'XL', 12),
(20, 105, 'S', 10),
(21, 105, 'M', 15),
(22, 105, 'L', 20),
(23, 105, 'XL', 12),
(24, 106, 'S', 10),
(25, 106, 'M', 15),
(26, 106, 'L', 20),
(27, 106, 'XL', 12),
(28, 107, 'S', 10),
(29, 107, 'M', 15),
(30, 107, 'L', 20),
(31, 107, 'XL', 12),
(32, 108, 'S', 10),
(33, 108, 'M', 15),
(34, 108, 'L', 20),
(35, 108, 'XL', 12),
(36, 109, 'S', 10),
(37, 109, 'M', 15),
(38, 109, 'L', 20),
(39, 109, 'XL', 12),
(40, 110, 'S', 10),
(41, 110, 'M', 15),
(42, 110, 'L', 20),
(43, 110, 'XL', 12),
(44, 111, 'S', 10),
(45, 111, 'M', 15),
(46, 111, 'L', 20),
(47, 111, 'XL', 12),
(48, 112, 'S', 10),
(49, 112, 'M', 15),
(50, 112, 'L', 20),
(51, 112, 'XL', 12),
(52, 113, 'S', 10),
(53, 113, 'M', 15),
(54, 113, 'L', 20),
(55, 113, 'XL', 12),
(56, 115, 'S', 10),
(57, 115, 'M', 15),
(58, 115, 'L', 20),
(59, 115, 'XL', 12),
(60, 116, 'S', 10),
(61, 116, 'M', 15),
(62, 116, 'L', 20),
(63, 116, 'XL', 12),
(64, 117, 'S', 10),
(65, 117, 'M', 15),
(66, 117, 'L', 20),
(67, 117, 'XL', 12),
(71, 119, '28', 10),
(72, 119, '29', 15),
(73, 119, '30', 20),
(74, 120, '28', 10),
(75, 120, '29', 15),
(76, 120, '30', 20),
(77, 121, '28', 10),
(78, 121, '29', 15),
(79, 121, '30', 20),
(80, 122, '28', 10),
(81, 122, '29', 15),
(82, 122, '30', 20),
(83, 123, '28', 10),
(84, 123, '29', 15),
(85, 123, '30', 20),
(86, 124, '28', 10),
(87, 124, '29', 15),
(88, 124, '30', 20),
(89, 125, '28', 10),
(90, 125, '29', 15),
(91, 125, '30', 20);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id_admin`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `ongkir`
--
ALTER TABLE `ongkir`
  ADD PRIMARY KEY (`id_ongkir`);

--
-- Indexes for table `pelanggan`
--
ALTER TABLE `pelanggan`
  ADD PRIMARY KEY (`id_pelanggan`);

--
-- Indexes for table `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id_pembayaran`);

--
-- Indexes for table `pembelian`
--
ALTER TABLE `pembelian`
  ADD PRIMARY KEY (`id_pembelian`);

--
-- Indexes for table `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  ADD PRIMARY KEY (`id_pembelian_produk`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id_produk`);

--
-- Indexes for table `produk_foto`
--
ALTER TABLE `produk_foto`
  ADD PRIMARY KEY (`id_produk_foto`);

--
-- Indexes for table `produk_ukuran`
--
ALTER TABLE `produk_ukuran`
  ADD PRIMARY KEY (`id_ukuran`),
  ADD KEY `id_produk` (`id_produk`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id_admin` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2026;

--
-- AUTO_INCREMENT for table `ongkir`
--
ALTER TABLE `ongkir`
  MODIFY `id_ongkir` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `pelanggan`
--
ALTER TABLE `pelanggan`
  MODIFY `id_pelanggan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id_pembayaran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pembelian`
--
ALTER TABLE `pembelian`
  MODIFY `id_pembelian` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `pembelian_produk`
--
ALTER TABLE `pembelian_produk`
  MODIFY `id_pembelian_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id_produk` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=126;

--
-- AUTO_INCREMENT for table `produk_foto`
--
ALTER TABLE `produk_foto`
  MODIFY `id_produk_foto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1102;

--
-- AUTO_INCREMENT for table `produk_ukuran`
--
ALTER TABLE `produk_ukuran`
  MODIFY `id_ukuran` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=92;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `produk_ukuran`
--
ALTER TABLE `produk_ukuran`
  ADD CONSTRAINT `produk_ukuran_ibfk_1` FOREIGN KEY (`id_produk`) REFERENCES `produk` (`id_produk`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
