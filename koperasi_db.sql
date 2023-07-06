-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 07 Jun 2023 pada 04.13
-- Versi server: 10.4.27-MariaDB
-- Versi PHP: 8.0.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `koperasi_db`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `orders`
--

CREATE TABLE `orders` (
  `order_id` int(11) UNSIGNED NOT NULL,
  `no_invoice` char(30) NOT NULL,
  `nama_siswa` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `no_hp` char(13) NOT NULL,
  `alamat` text NOT NULL,
  `payment_method` char(30) NOT NULL,
  `total` int(12) NOT NULL,
  `status` enum('BELUM BAYAR','PERLU DIKIRIM','PESANAN SELESAI') NOT NULL,
  `tgl_order` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orders`
--

INSERT INTO `orders` (`order_id`, `no_invoice`, `nama_siswa`, `email`, `no_hp`, `alamat`, `payment_method`, `total`, `status`, `tgl_order`) VALUES
(21, 'INV-20230606-3914', 'Ari Sumardi', 'arismrd13@gmail.com', '085158337129', 'Dusun Cijeungjing RT.002/RW.002, Desa Linggajaya, Kec. Cisitu, Kab. Sumedang, Jawa Barat', 'transfer_bank', 49000, 'PESANAN SELESAI', '2023-06-07 01:39:03'),
(22, 'INV-20230606-4305', 'Cecep', 'cecep@gmail.com', '085158337120', 'Dusun Cipari RT.002/RW.002, Desa Linggajaya, Kec. Cisitu, Kab. Sumedang, Jawa Barat', 'transfer_bank', 285000, 'PESANAN SELESAI', '2023-06-07 01:39:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_items`
--

CREATE TABLE `order_items` (
  `item_id` int(11) UNSIGNED NOT NULL,
  `order_id` int(11) UNSIGNED DEFAULT NULL,
  `produk_id` int(11) UNSIGNED DEFAULT NULL,
  `quantity` int(11) NOT NULL,
  `harga` int(12) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `order_items`
--

INSERT INTO `order_items` (`item_id`, `order_id`, `produk_id`, `quantity`, `harga`) VALUES
(33, 21, 1, 1, 16000),
(34, 21, 2, 1, 13000),
(35, 21, 3, 1, 20000),
(36, 22, 3, 1, 20000),
(37, 22, 1, 1, 16000),
(38, 22, 4, 1, 120000),
(39, 22, 5, 1, 129000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(11) UNSIGNED NOT NULL,
  `nama` char(50) NOT NULL,
  `harga` int(12) NOT NULL,
  `gambar` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `harga`, `gambar`) VALUES
(1, 'Dasi Biru', 16000, ''),
(2, 'Topi Sekolah', 13000, ''),
(3, 'Kaos Kaki SMP', 20000, ''),
(4, 'Baju Batik Sekolah', 120000, ''),
(5, 'Sepatu SMP', 129000, ''),
(6, 'Baju Olahraga', 200000, '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `roles`
--

CREATE TABLE `roles` (
  `id` int(11) NOT NULL,
  `role_name` char(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `roles`
--

INSERT INTO `roles` (`id`, `role_name`) VALUES
(1, 'admin'),
(2, 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(10) NOT NULL,
  `nama` char(50) NOT NULL,
  `alamat` text NOT NULL,
  `no_hp` char(13) NOT NULL,
  `username` char(25) NOT NULL,
  `password` varchar(150) NOT NULL,
  `email` char(50) NOT NULL,
  `kelas` char(10) NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `alamat`, `no_hp`, `username`, `password`, `email`, `kelas`, `role_id`) VALUES
(1, 'Roni Yanuar', 'Dsn. Cigintung, Desa Cigintung, Kec. Cisitu, Kab. Sumedang, Jawa Barat 45363', '085863727216', 'roniyanuar', 'cfbc23b045cc52e044536ef7eb64bc83', 'roniyanuar@gmail.com', 'VII A', 2),
(6, 'Ari Sumardi', 'Dusun Cijeungjing RT.002/RW.002, Desa Linggajaya, Kec. Cisitu, Kab. Sumedang, Jawa Barat', '085158337129', 'sumardi', '82ea6d007f087efa9d52840eed117c3a', 'arismrd13@gmail.com', 'IX C', 2),
(23, 'Cecep', 'Dusun Cipari RT.002/RW.002, Desa Linggajaya, Kec. Cisitu, Kab. Sumedang, Jawa Barat', '085158337120', 'cecep6', 'fe15b1f7d40abbc095fce967cb4fb9ed', 'cecep@gmail.com', 'IX A', 2),
(45, 'ADMIN', 'ADMIN', '085158337129', 'admin123', '0192023a7bbd73250516f069df18b500', 'roniyanuar@gmail.com', '-', 1);

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`order_id`);

--
-- Indeks untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `orders`
--
ALTER TABLE `orders`
  MODIFY `order_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT untuk tabel `order_items`
--
ALTER TABLE `order_items`
  MODIFY `item_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=40;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `order_items`
--
ALTER TABLE `order_items`
  ADD CONSTRAINT `order_items_ibfk_1` FOREIGN KEY (`order_id`) REFERENCES `orders` (`order_id`),
  ADD CONSTRAINT `order_items_ibfk_2` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
