-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 24, 2025 at 08:41 AM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Table structure for table `detail_transaksi`
--

CREATE TABLE `detail_transaksi` (
  `id` int NOT NULL,
  `transaksi_id` int NOT NULL,
  `produk_id` int NOT NULL,
  `qty` int NOT NULL,
  `harga_satuan` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `detail_transaksi`
--

INSERT INTO `detail_transaksi` (`id`, `transaksi_id`, `produk_id`, `qty`, `harga_satuan`) VALUES
(1, 65, 31, 1, 5000),
(2, 66, 2, 1, 3000),
(3, 67, 2, 1, 3000),
(4, 68, 32, 2, 6000),
(5, 68, 1, 1, 3000),
(6, 69, 5, 2, 2500),
(7, 69, 2, 1, 3000),
(8, 70, 1, 1, 3000),
(9, 71, 1, 1, 3000),
(10, 72, 1, 1, 3000),
(11, 73, 2, 1, 3000),
(12, 74, 28, 3, 7000),
(13, 75, 31, 2, 5000),
(14, 76, 1, 1, 3000),
(15, 77, 32, 2, 6000),
(16, 78, 2, 1, 3000),
(17, 79, 1, 1, 3000),
(18, 80, 31, 1, 5000),
(19, 81, 1, 1, 3000),
(20, 82, 2, 1, 3000);

--
-- Triggers `detail_transaksi`
--
DELIMITER $$
CREATE TRIGGER `kurangstok` AFTER INSERT ON `detail_transaksi` FOR EACH ROW BEGIN
    UPDATE produk
    SET stok = stok - NEW.qty
    WHERE id = NEW.produk_id;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id_kategori` int NOT NULL,
  `nama_kategori` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id_kategori`, `nama_kategori`) VALUES
(1, 'donat kentang'),
(2, 'donat madu\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `harga` int DEFAULT NULL,
  `stok` int DEFAULT NULL,
  `foto` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `deskripsi` text,
  `id_kategori` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `produk`
--

INSERT INTO `produk` (`id`, `nama`, `harga`, `stok`, `foto`, `deskripsi`, `id_kategori`) VALUES
(1, 'donat matcha', 3000, 3, 'donat matcha.jpg', 'Donat lembut dengan rasa matcha khas Jepang. Manisnya pas, ada pahit dikit khas teh hijau yang bikin nagih banget buat pecinta matcha.', 1),
(2, 'donat messe coklat', 3000, 6, 'donuts.jpg', 'Coklat lovers wajib coba! Donat empuk dibalut coklat manis yang lumer di mulut. Rasanya simpel tapi bikin mood langsung naik.', 1),
(3, 'glaze coklat springkle', 2500, 10, 'donat selai coklat.jpeg', 'donat yang lembut dan taburan spingkle yang warna-warni dan hiasan drizzle krim putih yang manis', 2),
(4, 'keju parut', 2500, 10, 'donat keju parut.jpeg', 'Donat empuk + krim manis + taburan keju parut yang banyak banget di atasnya. Gurih dan manisnya bikin lidah happy terus.', 1),
(7, 'coklat kacang', 6000, 10, 'donat coklat kacang.jpeg', 'donat dengan lapisan glaze coklat dan taburan kacang yang renyah', 2),
(26, 'donat salju', 2500, 10, 'donat gula halus.jpeg', 'Donat klasik favorit semua orang. Lembut, empuk, dan manis dengan taburan gula halus kayak salju yang bikin tiap gigitan mantep.', 1),
(27, 'bomboloni tiramisu', 2500, 10, 'donat gula halus daleman krim tiramisu.jpeg', 'donat yang di isi oleh glaze tiramisu dan ditambahkan taburan gula halus', 1),
(28, 'matcha spiderman', 7000, 17, 'donat selai matcha dan white coklat.jpeg', 'donat yang diberi glaze matcha dan di beri glaze putih dimotif seperti sarang laba-laba', 2),
(29, 'glaze coklat ', 7000, 20, 'WhatsApp Image 2025-08-10 at 19.51.25.jpeg', 'donat yang diberi glaze coklat di dihias oleh glazee putih', 2),
(30, 'bomboloni blueberry', 2500, 10, 'donat gula halus daleman krim coklat.jpeg', 'donat yang diisi oleh selai blueberry dan ditaburi gula halus yang berlimpah', 1),
(31, 'Donat Choco Sprinkle', 5000, 7, '1756696728_Menu _ Local Donut Shop.jpg', 'Donat lembut berlapis cokelat manis yang dilumuri taburan meises cokelat melimpah. Tekstur empuk dari adonan berpadu dengan rasa cokelat yang kaya, memberikan sensasi manis yang pas untuk teman santai ataupun camilan kapan saja.', 2),
(32, 'tiramisu lumer', 6000, 6, '1756697000_ChatGPT Image 1 Sep 2025, 10.21.41.png', 'Donat empuk dengan topping krim tiramisu khas rasa kopi yang lembut, dilapisi drizzle cokelat yang manis, dan dihiasi biskuit Oreo di atasnya. Perpaduan rasa kopi, cokelat, dan manisnya donat membuatnya jadi pilihan sempurna untuk pecinta dessert yang ingin sensasi lumer di mulut.', 2);

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id_transaksi` int NOT NULL,
  `id_pelanggan` int NOT NULL,
  `tanggal` date NOT NULL,
  `total_harga` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id_transaksi`, `id_pelanggan`, `tanggal`, `total_harga`) VALUES
(65, 2, '2025-09-10', 5000),
(66, 2, '2025-09-10', 3000),
(67, 2, '2025-09-11', 3000),
(68, 2, '2025-09-16', 15000),
(69, 2, '2025-09-17', 8000),
(70, 10, '2025-09-17', 3000),
(71, 3, '2025-09-17', 3000),
(72, 3, '2025-09-19', 3000),
(73, 11, '2025-09-19', 3000),
(74, 12, '2025-09-19', 21000),
(75, 2, '2025-09-22', 10000),
(76, 2, '2025-09-22', 3000),
(77, 2, '2025-09-22', 22000),
(78, 2, '2025-09-22', 13000),
(79, 2, '2025-09-22', 13000),
(80, 2, '2025-09-22', 15000),
(81, 2, '2025-09-22', 13000),
(82, 2, '2025-09-22', 13000);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `nama` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `profile_picture` varchar(255) DEFAULT NULL,
  `username` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `hp` varchar(255) DEFAULT NULL,
  `alamat` varchar(255) DEFAULT NULL,
  `role` enum('admin','pelanggan') DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `profile_picture`, `username`, `password`, `hp`, `alamat`, `role`) VALUES
(1, 'admin', 'admin@gmail.com', 'img/1.jpg', 'admin', 'admin123', NULL, NULL, 'admin'),
(2, 'debby fanesa putri', 'debbyfanesaputri@gmail.com', 'profile_2.jpg', 'debboyy', 'bKENegw1', '089667757755', 'jl.jendral sudirman', 'pelanggan'),
(3, 'debby fanesa putri', 'debbyfanesaputri@gmail.com', '', 'debby', '1234', '089667757755', 'jl.jendral sudirman', 'pelanggan'),
(4, 'ciya', 'ciya@gmail.com', 'img/1755408996_WhatsApp Image 2025-08-10 at 19.51.25.jpeg', 'ciya', 'sS1PaHUB', '0897566443', 'ploto\r\n', 'pelanggan'),
(5, 'sela', 'sela@gmail.com', 'img/1755409148_WhatsApp Image 2025-08-10 at 15.23.01.jpeg', 'selacantik', 'sela22', '085921903893', 'Argapura', 'pelanggan'),
(6, 'sofi', 'sofi@gmail.com', NULL, 'sofii', 'XICis2db', '0888749', 'dr sutomo', 'pelanggan'),
(7, 'ardan ', 'ardan@gmail.com', NULL, 'ardan', 'Gnq2AuOd', '0888749', 'jl.angkasa', 'pelanggan'),
(8, 'sela mutiara', 'sela@gmail.com', NULL, 'sela', 'sela22', '085921903893', 'Neper', 'pelanggan'),
(9, 'moch sulthan', 'sultan22@gmail.com', 'profile_9.jpeg', 'moch sulthan', 'fQWnPduK', '085921903893', 'Neper', 'pelanggan'),
(10, 'EVA', 'nave@gmail.com', 'profile_10.jpg', 'eva', 'dq4GU8IQ', '08966543322', 'jl.jendral sudirman', 'pelanggan'),
(11, 'dann', 'dandindun@gmail.com', 'profile_11.jpg', 'danto', 'ardannn', '08964321245', 'cirebon', 'pelanggan'),
(12, 'anisa', 'anisa@gmail.com', 'profile_12.jpg', 'nisa', '123', '089667757755', 'jl.angkasa', 'pelanggan');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `transaksi_id` (`transaksi_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_kategori` (`id_kategori`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id_transaksi`),
  ADD KEY `id_pelanggan` (`id_pelanggan`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `detail_transaksi`
--
ALTER TABLE `detail_transaksi`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id_kategori` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id_transaksi` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_ibfk_1` FOREIGN KEY (`id_pelanggan`) REFERENCES `users` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
