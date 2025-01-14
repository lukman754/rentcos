-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 14, 2025 at 03:23 PM
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
-- Database: `rentcos`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_admin`
--

CREATE TABLE `tb_admin` (
  `admin_id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_admin`
--

INSERT INTO `tb_admin` (`admin_id`, `username`, `password`) VALUES
(1, 'chopin', '72onevif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_costume`
--

CREATE TABLE `tb_costume` (
  `id_cos` int(11) NOT NULL,
  `id_owner` int(11) NOT NULL,
  `id_kat` int(11) DEFAULT NULL,
  `id_series` int(11) NOT NULL,
  `id_gender` int(11) NOT NULL,
  `id_status` int(11) NOT NULL,
  `foto1` varchar(255) DEFAULT NULL,
  `foto2` varchar(255) DEFAULT NULL,
  `foto3` varchar(255) DEFAULT NULL,
  `cos_name` varchar(100) NOT NULL,
  `c_desc` text DEFAULT NULL,
  `brand` varchar(100) DEFAULT NULL,
  `size` varchar(50) DEFAULT NULL,
  `price` decimal(10,2) DEFAULT NULL,
  `link` text NOT NULL,
  `time` int(11) DEFAULT NULL,
  `created_at` date NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `status` varchar(100) NOT NULL,
  `validation_status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_hungarian_ci DEFAULT 'pending',
  `views` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_costume`
--

INSERT INTO `tb_costume` (`id_cos`, `id_owner`, `id_kat`, `id_series`, `id_gender`, `id_status`, `foto1`, `foto2`, `foto3`, `cos_name`, `c_desc`, `brand`, `size`, `price`, `link`, `time`, `created_at`, `updated_at`, `status`, `validation_status`, `views`) VALUES
(51, 16, 3, 34, 2, 1, '161_ayami1.webp', '162_ayami1.1.webp', '', 'Gawr Gura', '🌹Ready for rent!\r\n*+:｡.｡　｡.｡:+*\r\n\r\nGawr Gura\r\n70k / 3 hari\r\nRealpic di slide ke 2.\r\n\r\n[Wajib mengikuti SnK]\r\nHarga belum termasuk ongkir 💋', 'Mangu', 'M', 70000.00, 'https://www.instagram.com/p/DClWtYqpyk9/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-19 05:39:43', 'aktif', 'approved', 3),
(52, 16, 3, 13, 1, 1, '161_ayami2.webp', '162_ayami2.2.webp', '', 'Kaito', 'Ready✅\r\nDM for booking !\r\n*+:｡.｡　｡.｡:+*\r\n\r\nKaito Vocaloid\r\n70 k / 3 hari\r\n[Wajib mengikuti SnK]\r\n\r\nHarga belum termasuk ongkir 💋', 'Maker Lokal', 'XL', 70000.00, 'https://www.instagram.com/p/DC4j2l2h8sr/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-11 12:03:43', 'aktif', 'approved', 1),
(53, 16, 3, 9, 2, 1, '161_ayami3.webp', '162_ayami3.3.webp', '', 'Shinobu Kocho', 'Ready✅\r\nDM for booking !\r\n*+:｡.｡　｡.｡:+*\r\n\r\nShinobu Kocho\r\n60 k / 3 hari\r\n[Wajib mengikuti SnK]\r\n\r\nHarga belum termasuk ongkir 💋', 'No Brand', 'XL', 60000.00, 'https://www.instagram.com/p/DC9i3xcydtH/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-16 06:51:13', 'aktif', 'approved', 1),
(54, 16, 3, 7, 2, 1, '161_ayami4.webp', '162_ayami4.4.webp', '', 'Lumine', '🌹Ready for rent!\r\n*+:｡.｡　｡.｡:+*\r\n\r\nLumine Genshin Impact\r\n90k / 3 hari\r\nRealpic di slide ke 2.\r\n\r\n[Wajib mengikuti SnK]\r\nHarga belum termasuk ongkir 💋', 'Wudu', 'L', 90000.00, 'https://www.instagram.com/p/DC3E4Biyu7L/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-10 07:51:06', 'aktif', 'approved', 0),
(55, 16, 3, 9, 2, 1, '161_ayami5.webp', '162_ayami5.5.webp', '', 'Kanao Tsuyuri', 'Ready✅\r\nDM for booking !\r\n*+:｡.｡　｡.｡:+*\r\n\r\nKanao\r\n50 k / 3 hari\r\n[Wajib mengikuti SnK]\r\n\r\nHarga belum termasuk ongkir 💋', 'No Brand', 'M', 50000.00, 'https://www.instagram.com/p/DC9hv4_yx4M/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-10 07:51:07', 'aktif', 'approved', 0),
(56, 17, 4, 7, 2, 1, '171_uki1.webp', '172_uki2.webp', '173_uki3.webp', 'Ganyu', 'Ganyu Wig Acc Only\r\n\r\n‼️ Wig sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Wig Only : 40k /3day\r\n— wig brand ruler\r\n\r\n♡ Wig + Acc : 50k / 3day\r\n— wig brand ruler, horn 2x (eva foam base)\r\n\r\n🏋 Berat Ongkir 1kg / Medium.\r\n‼️ Sudah Include Biaya Repair (RINGAN).\r\n🚚 Pengiriman dari Singosari, Malang.', 'Ruler', 'All size', 40000.00, 'https://www.instagram.com/p/C_WxxW3y18O/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-10 08:03:50', 'aktif', 'approved', 0),
(57, 17, 4, 7, 2, 1, '171_uki4.webp', '172_uki5.webp', '173_uki6.webp', 'Raiden Shogun', 'Raiden Wig Acc Only\r\n\r\n💜 Versi Office (postingan menyusul) = 65K\r\n‼️ Wig sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Wig Only : 50k /3day\r\n— wig brand manmei (crimped/gembul)\r\n\r\n♡ Wig + Acc : 55k / 3day\r\n— wig brand manmei, pin (eva foam base)\r\n\r\n🏋 Berat Ongkir 1kg / Medium.\r\n‼️ Sudah Include Biaya Repair (RINGAN).\r\n🚚 Pengiriman dari Singosari, Malang.', 'ManMei', 'All size', 50000.00, 'https://www.instagram.com/p/DAxN9O3y0QG/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-11 12:04:55', 'aktif', 'approved', 1),
(58, 17, 3, 67, 2, 1, '171_uki7.jpg', '172_uki8.jpg', '173_uki9.jpg', 'Nanami Kento Female', 'Nanami Kento Female (Size M fit L) - Hanya ada 1 Size 🌷\r\n\r\n‼️ Kostum sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Nanami set wig : 70k / 3day\r\n— kemeja satin, leopard tie, sabuk, body belt, celana / rok (pilih 1), wig, weapon.\r\n\r\n♡ Nanami set hijab : 65k / 3day\r\n— kemeja satin, leopard tie, sabuk, body belt, celana / rok (pilih 1), hijab pashmina, weapon.\r\n\r\n🏋 Berat Ongkir 1Kg / Medium-Large)\r\n‼️ Sudah Include Biaya Laundry.\r\n🔖 Costume Local Maker.\r\n🚚 Pengiriman dari Singosari, Malang.', 'Maker Lokal', 'M', 70000.00, 'https://www.instagram.com/p/DDRVrGJpGC2/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-10 08:19:00', 'aktif', 'approved', 0),
(59, 17, 3, 6, 2, 1, '171_uki10.webp', '172_uki11.webp', '173_uki12.webp', 'Sparkle / Hanabi', 'Sparkle (Size S fit to M) - Hanya ada 1 Size 🌷\r\n\r\n💪🏻 Minimal Punya 1x Pengalaman rental Kostum Rumit, Disertakan bukti.\r\n⚠️ Acc Yang rawan hilang Harap diteliti / digunakan ketika Photosession saja!\r\n‼️ Kostum sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Sparkle set wig : 130k / 3day\r\n— dress, sleeve (2pc), manset, safety pants, kemben, obi, bow, tali obi, choker, sarung tangan kain, sarung tangan tali, tali paha, tali kaki (2pc), jepit pita, jepit lonceng, topeng kitsune, acc jepit rambut (2pc).\r\n\r\n🤍 tidak menyediakan set hijab demi kebaikan bersama\r\n🥷 apabila manset, safety pants, / kemben tidak dipakai. harap konfirmasi.\r\n\r\nADDITIONAL :\r\n💸 Beli Bra strap bening : +5k\r\n\r\n🏋 Berat Ongkir 1Kg / Medium-Large.\r\n‼️ Sudah Include Biaya Laundry.\r\n🔖 Costume WuDu HQ, Wig Manmei.\r\n🚚 Pengiriman dari Singosari, Malang.', 'Wudu Upgrade', 's', 130000.00, 'https://www.instagram.com/p/C9WC7Loy0Qr/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-10 08:19:01', 'aktif', 'approved', 0),
(60, 18, 5, 7, 2, 1, '181_neon1.webp', '182_neon1.1.webp', '', 'Iron Sting', '[READY]\r\nYMMA (yang malang malang aja)\r\nBuatan maker rapid.props\r\nBisa buat clorinde/kazuha nya mimin :9\r\n\r\nDikirim dari Malang', 'Maker Lokal', 'All size', 45000.00, 'https://www.instagram.com/p/C8WNkusB70f/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-10 08:31:51', 'aktif', 'approved', 0),
(61, 18, 5, 7, 2, 1, '181_neon2.webp', '182_neon2.2.webp', '183_neon2.3.webp', 'Lumine', '[READY FOR RENT]\r\n\r\nBerat 1kg\r\nYMMA (yang malang-malang aja)\r\nBisa COD di rumah mimin dan di Event atau gosend\r\nDikirim dari malang', 'Maker Lokal', 'All size', 75000.00, 'https://www.instagram.com/p/C3JsgR8BUAf/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-10 08:31:51', 'aktif', 'approved', 0),
(62, 18, 3, 68, 1, 1, '181_neon3.webp', '182_neon3.2.webp', '', 'Mafumafu', 'Ready For rent!!\r\nSIZE XL - FREE NOEN\r\n(1kg) Paxel [Small]\r\nInclude biaya laundry ✅️\r\nFirst rent ✅️\r\n\r\nKondisi : 90%\r\n- Sayapnya ada, cuman kuizinin di daerah malang aja :\") +30k\r\n-Only Wig (30k)\r\n\r\nDikirim dari Malang', 'Maker Lokal', 'L', 60000.00, 'https://www.instagram.com/p/CokHG_ByUAG/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-10', '2024-12-19 05:39:30', 'aktif', 'approved', 2),
(63, 18, 3, 7, 2, 1, '181_neon4.webp', '182_neon4.4.webp', '', 'Nilou', 'eady for rent ~\r\nSIZE M-L NOEN (adjustable)\r\n(3kg) Paxel [Large]\r\nInclude biaya laundry ✅️\r\nInclude Sandal size 38 ✅️\r\nMin. 1x pengalaman rental costume genshin/hsr\r\n\r\nKondisi : 80%\r\n-Only Wig (50k)\r\n\r\nPengiriman dari Malang', 'Wetrose', 'XL', 150000.00, 'https://www.instagram.com/p/CpcVmtZB_C8/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 17:59:41', 'aktif', 'approved', 0),
(65, 18, 3, 13, 2, 1, '181_neon6.webp', '182_neon6.1.jpg', '', 'Megurine Luka', '[Ready For Rent]\r\nSIZE L NOEN\r\n(2kg) Paxel [Medium]\r\nInclude biaya laundry ✅️\r\nFirst rent ✅️\r\n-Only Wig (45k)\r\n+boots luka size 37 (30k)\r\n\r\nKondisi : 95%\r\nDikirim dari Malang', 'Yuan Yuan', 'L', 150000.00, 'https://www.instagram.com/p/CwCzMTXhZnt/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 17:59:42', 'aktif', 'approved', 0),
(66, 18, 5, 7, 999, 1, '181_neon5.webp', '182_neon5.1.webp', '', 'Cyno', '[READY FOR RENT]\r\nIni bagus banget asli, karyanya @rapid.props\r\n\r\nBerat 1kg\r\nYMMA (yang malang-malang aja)\r\nBisa COD di rumah mimin dan di Event atau gosend\r\nDikirim dari malang', 'Maker Lokal', 'All size', 70000.00, 'https://www.instagram.com/p/CyJjzKIBgGX/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:16:02', 'aktif', 'approved', 0),
(67, 18, 3, 13, 2, 1, '181_neon7.webp', '182_neon7.1.jpg', '183_neon7.2.jpg', 'Hatsune Miku', '[READY]\r\nSIZE M-L NOEN\r\nMin. 1x pengalaman rental costume semi rumit\r\n2kg [PAXEL Medium] costume + wig only\r\n4kg [PAXEL Big] costume + wig + sayap (sayapnya masuk 2kg (volume))\r\nJNT HBO (cargo) bisa✅️ lebih murah untuk paket size besar ✅️\r\n\r\nInclude biaya laundry ✅️\r\ndikirim dari Malang\r\n- Only wig (55k) + acc kepala (+25k)\r\n- sayap (+15k)', 'Wudu', 'XL', 100000.00, 'https://www.instagram.com/p/C8WM_uxhX59/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-11 01:59:52', 'aktif', 'approved', 1),
(68, 18, 3, 69, 2, 1, '181_neon8.jpg', '182_neon8.1.jpg', '183_neon8.2.jpg', 'Rin Kagamine', '[Ready]\r\nSIZE XL (M fit L)\r\n2kg [PAXEL Medium] costume + wig only\r\n\r\nFirst rent ✅️\r\nInclude biaya laundry ✅️\r\ndikirim dari Malang\r\n- Only wig (45k)\r\n- Only Costume (65k)', 'No Brand', 'M', 85000.00, 'https://www.instagram.com/p/C_zZmf0SxK-/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:15:59', 'aktif', 'approved', 0),
(69, 18, 3, 70, 2, 1, '181_neon9.jpg', '182_neon9.1.jpg', '', 'Ai Hoshino', '[READY]\r\n3kg [PAXEL Large]\r\ndikirim dari Malang\r\nFirst rent ✅️\r\nInclude biaya laundry ✅️\r\n\r\n- Only wig + acc kepala (45k)', 'Maker Lokal', 'XL', 75000.00, 'https://www.instagram.com/p/C32TUuGhdRX/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:16:01', 'aktif', 'approved', 0),
(70, 17, 3, 32, 2, 1, '171_uki13.jpg', '172_uki14.jpg', '173_uki15.jpg', 'Slytherin', '‼️ HANYA ADA SATU (1) SETEL ‼️ & GAPUNYA RAVENCLAW & HUFFLEPUFF 😃\r\n\r\nHarry Potter Slytherin (Size L) - Hanya ada 1 Size 🌷\r\n\r\n‼️ Kostum sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Slytherin set A : 75k / 3day\r\n— kemeja, celana, dasi, vest, jubah, topi, tongkat sihir, kacamata\r\n\r\n♡ Slytherin set B : 65k / 3day\r\n— dasi, vest, jubah, topi, tongkat sihir, kacamata\r\n\r\n♡ Slytherin set C : 55k / 3day\r\n— dasi, vest, jubah, tongkat\r\n\r\nADDITIONAL :\r\n☆ Sepatu (Cek postingan sepatu)\r\n\r\n🏋 Berat Ongkir 1Kg / Medium-Large.\r\n‼️ Sudah Include Biaya Laundry.\r\n🔖 Costume Local.\r\n🚚 Pengiriman dari Singosari, Malang.', 'No Brand', 'L', 75000.00, 'https://www.instagram.com/p/DBl_U2OSkaO/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:23:30', 'aktif', 'approved', 0),
(71, 17, 3, 71, 2, 1, '171_uki16.jpg', '172_uki17.jpg', '173_uki18.jpg', 'Zero Two', 'Zero two (Size M) - Hanya ada 1 Size 🌷\r\n\r\n‼️ Kostum sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n📝 : Bisa First Rent, Namun Wajib Deposit Uang Jaminan 25k (Antisipasi Khusus Wig Rawan Kusut)\r\n\r\n♡ Zero two set wig : 55k / 3day\r\n— costume, wig (brand don\'t sleep), acc kepala, stocking.\r\n\r\n♡ Zero two set hijab : 50k / 3day\r\n— costume, pashmina, acc kepala, leging wudhu.\r\n\r\n🏋 Berat Ongkir 1Kg / Medium.\r\n‼️ Sudah Include Biaya Laundry.\r\n🔖 Costume Local Maker, Wig Don\'t Sleep.\r\n🚚 Pengiriman dari Singosari, Malang.', 'Maker Lokal', 'M', 55000.00, 'https://www.instagram.com/p/CvjtlELBoIC/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:34:36', 'aktif', 'approved', 0),
(72, 17, 3, 9, 2, 1, '171_uki19.jpg', '172_uki20.jpg', '173_uki21.jpg', 'Nezuko Kamado', 'Kamado Nezuko (Size M to L) - Hanya ada 1 Size 🌷\r\n\r\n🩴 SUDAH INCLUDE GETA\r\n📝 : Bisa First Rent, Namun Wajib Deposit Uang Jaminan 25k (Antisipasi Khusus Wig Rawan Kusut)\r\n\r\n‼️ Kostum sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Kamado Nezuko set wig : 90k / 3day\r\n— kimono, obi+acc, haori, bamboo, wig (brand manmei), acc pita, kaos kaki, sarung kaki+acc, geta/sandal.\r\n\r\n♡ Kamado Nezuko set hijab : 85k / 3day\r\n— kimono, obi+acc, haori, bamboo, hijab bella, hijab pashkina, acc pita peniti, kaos kaki, sarung kaki+acc, geta/sandal.\r\n\r\n🏋 Berat Ongkir 2Kg / Medium.\r\n‼️ Sudah include biaya laundry.\r\n🔖 Costume Free Brand, Wig Manmei.\r\n🚚 Pengiriman dari Singosari, Malang.', 'No Brand', 'M', 90000.00, 'https://www.instagram.com/p/CxRgMFYhQj1/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:34:37', 'aktif', 'approved', 0),
(73, 17, 3, 6, 2, 1, '171_uki22.jpg', '172_uki23.jpg', '173_uki24.jpg', 'Qingque', 'Qingque HSR (Size L) - Hanya ada 1 Size 🌷\r\n\r\n‼️ Kostum sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Qingque set wig : 100k / 3day\r\n— atasan, rok, wig (brand manmei), jepit mochi, jepit kacang, handsocks 2x, acc sepatu 2x.\r\n\r\n♡ Qingque set hijab : 95k / 3day\r\n— atasan, rok, manset hitam, leging wudhu, hijab pashmina / bella square 2x, jepit mochi, jepit kacang, handsocks 2x, acc sepatu 2x.\r\n\r\nADDITIONAL :\r\n☆ Black Boots Pendek : +10k\r\n\r\n🏋 Berat Ongkir 2Kg / Medium.\r\n‼️ Sudah Include Biaya Laundry.\r\n🔖 Costume WuDu, Wig Manmei.\r\n🚚 Pengiriman dari Singosari, Malang.', 'Wudu', 'L', 100000.00, 'https://www.instagram.com/p/DBl0eO_yLYj/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:34:37', 'aktif', 'approved', 0),
(74, 17, 3, 72, 2, 1, '171_uki25.jpg', '172_uki26.jpg', '173_uki27.jpg', 'Anya Forger', 'Anya Forger (Size M) - Hanya ada 1 Size 🌷\r\n\r\n‼️ Kostum sewa, kondisinya tidak 100% karena seringnya disewakan.\r\n\r\n♡ Anya Seifuku set wig : 65k / 3day\r\n— costume (dress), wig (manmei), acc kepala, (tanpa kaos kaki).\r\n\r\n♡ Anya Seifuku set hijab : 60k / 3day\r\n— costume (dress), pashmina, acc kepala, leging wudhu.\r\n\r\nADDITIONAL :\r\n☆ Pantofel Shoes (Brown-37/24,5) : +10k\r\n\r\n🏋 Berat Ongkir 1Kg / Small.\r\n‼️ Sudah Include Biaya Laundry.\r\n🔖 Costume No Brand, Wig Manmei.\r\n🚚 Pengiriman dari Singosari, Malang.', 'No Brand', 'M', 65000.00, 'https://www.instagram.com/p/Cx0YOo1hyFg/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:34:38', 'aktif', 'approved', 0),
(75, 16, 3, 6, 2, 1, '161_ayami6.jpg', '162_ayami6.6.jpg', '', 'Kafka', '✅Ready💞\r\nDM for booking !\r\n*+:｡.｡　｡.｡:+*\r\n\r\nKafka Honkai Star Rail\r\n130k / 3 hari\r\n[Wajib mengikuti SnK]\r\n\r\nHarga belum termasuk ongkir 💋', 'Wudu Upgrade', 'L - XL', 130000.00, 'https://www.instagram.com/p/DDUf2SYSTlL/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:50:47', 'aktif', 'approved', 0),
(76, 16, 3, 9, 2, 1, '161_ayami7.jpg', '162_ayami7.7.jpg', '', 'Mitsuri Kanroji', '✅Ready💞\r\nDM for booking !\r\n*+:｡.｡　｡.｡:+*\r\n\r\nMitsuri kaneoji\r\n75k / 3 hari\r\n[Wajib mengikuti SnK]\r\n\r\nHarga belum termasuk ongkir 💋', 'No Brand', 'M - L', 75000.00, 'https://www.instagram.com/p/DDOyAywp2AK/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:50:48', 'aktif', 'approved', 0),
(77, 16, 3, 6, 1, 1, '161_ayami8.jpg', '162_ayami8.8.jpg', '', 'Sunday', '🌹Ready for rent!\r\n*+:｡.｡　｡.｡:+*\r\n\r\nSunday\r\n110k / 3 hari\r\n[Wajib mengikuti SnK]\r\n\r\nHarga belum termasuk ongkir 💋', 'Wudu', 'L', 110000.00, 'https://www.instagram.com/p/DCbYbVOyR7s/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-11 01:48:18', 'aktif', 'approved', 1),
(78, 16, 3, 73, 1, 1, '161_ayami9.jpg', '162_ayami9.9.jpg', '', 'Jett', 'Ready✅\r\nDM for booking !\r\n*+:｡.｡　｡.｡:+*\r\n\r\nValorant Jett\r\n115 k / 3 hari\r\n[Wajib mengikuti SnK]\r\n\r\nHarga belum termasuk ongkir 💋', 'CosplayFM', 'L', 115000.00, 'https://www.instagram.com/p/DC6QooEyLGC/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 18:55:13', 'aktif', 'approved', 0),
(79, 19, 3, 74, 2, 1, '191_ohaku1.jpg', '192_ohaku1.1.jpg', '193_ohaku1.2.jpg', 'Iris', '✅ READY FOR RENT ✅\r\nSISTER IRIS (Fire Force)\r\n\r\nPrice Rent 125k/3hari\r\n\r\nSize M\r\nLD 82-85 cm\r\nLP 66-68 cm\r\n\r\nInclude:\r\n- Costume Freebrand Taobao\r\n- Wig Manmei\r\n- Acc\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'No Brand', 'M', 125000.00, 'https://www.instagram.com/p/CpK5njghUxw/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:21:54', 'aktif', 'approved', 0),
(80, 19, 3, 67, 1, 1, '191_ohaku2.jpg', '192_ohaku2.1.jpg', '193_ohaku2.2.jpg', 'Itadori Yuuji', '✅ READY FOR RENT ✅\r\n\r\nITADORI YUJI - JUJUTSU KAISEN\r\n\r\nPrice Rent 85k/3hari\r\n\r\nSize L\r\nLD : 95-102 cm\r\nWaist : 80-86 cm\r\n\r\nInclude:\r\n- Costume JIANGCHENG\r\n- Wig Manmei\r\n\r\nExclude:\r\n- Weapon +10.000 (bisa di kirim)\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'Jiangcheng', 'L', 85000.00, 'https://www.instagram.com/p/Ci_cEZlhGbO/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:21:51', 'aktif', 'approved', 0),
(81, 19, 3, 74, 1, 1, '191_ohaku3.jpg', '192_ohaku3.1.jpg', '', 'Shinra Kusakabe', '✅ READY FOR RENT ✅\r\nSHINRA KUSAKABE (Fire Force)\r\n\r\nPrice Rent 80k/3hari\r\n\r\n*Size M :\r\nLD 108\r\nLP 104\r\nPanjang 145\r\n\r\n*Size L :\r\nLD 112\r\nLP 108\r\nPanjang 148\r\n\r\nInclude:\r\n- Costume Freebrand Taobao\r\n- Wig manmei\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'No Brand', 'L', 80000.00, 'https://www.instagram.com/p/CpKzdJVBtBL/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:21:52', 'aktif', 'approved', 0),
(82, 19, 3, 74, 2, 1, '191_ohaku4.jpg', '192_ohaku4.1.jpg', '', 'Tamaki Kotatsu', '✅ READY FOR RENT ✅\r\nTAMAKI KOTATSU (Fire Force)\r\n\r\nPrice Rent 80k/3hari\r\n\r\n*Size S :\r\nLD 102\r\nLP 98\r\nPanjang 137\r\n\r\n*Size M :\r\nLD 108\r\nLP 104\r\nPanjang 146\r\n\r\nInclude:\r\n- Costume Freebrand Taobao\r\n- Wig manmei\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'No Brand', 's', 80000.00, 'https://www.instagram.com/p/CpKyZVthlFE/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:21:54', 'aktif', 'approved', 0),
(83, 19, 3, 7, 2, 1, '191_ohaku5.jpg', '192_ohaku5.1.jpg', '193_ohaku5.2.jpg', 'Raiden Shogun', '✅ READY FOR RENT ✅\r\nRAIDEN SHOGUN (Genshin Impact)\r\n\r\nPrice Rent 135k/3hari\r\n\r\nSize M\r\nLD 85-90 cm\r\nLP 68-73 cm\r\n\r\nInclude:\r\n- Costume Lardoo (Taobao)\r\n- Wig Manmei\r\n- Accesories\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'Lardoo', 'M', 135000.00, 'https://www.instagram.com/p/CpPskPxhJy9/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:21:55', 'aktif', 'approved', 0),
(84, 19, 3, 75, 1, 1, '191_ohaku6.jpg', '', '', 'Gojo Wakana', '✅ READY FOR RENT ✅\r\nGOJO WAKANA (My Dress Up Darling)\r\n\r\nPrice Rent 50k/3hari\r\n\r\nSize L\r\nLD 53cm\r\nLP 81cm\r\n\r\nInclude:\r\n- Costume Maker Lokal\r\n- Accesories\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'Maker Lokal', 'L', 50000.00, 'https://www.instagram.com/p/CjAuPCErgOx/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:21:53', 'aktif', 'approved', 0),
(85, 19, 3, 75, 2, 1, '191_ohaku7.jpg', '192_ohaku7.1.jpg', '193_ohaku7.2.jpg', 'Shizuku Tan', '✅ READY FOR RENT ✅\r\nSHIZUKU TAN (My Dress Up Darling)\r\n\r\nPrice Rent 115k/3hari\r\n\r\nSize L\r\nL Dada 86-90 cm\r\nL Pinggang 76-80 cm\r\nPanjang 90 cm\r\n\r\nInclude:\r\n- Costume Domandu (Taobao)\r\n- Wig Manmei\r\n- Accesories\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'Domandu', 'L', 115000.00, 'https://www.instagram.com/p/CigV_aBBZZ6/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:27:23', 'aktif', 'approved', 0),
(86, 19, 3, 72, 1, 1, '191_ohaku8.jpg', '192_ohaku8.1.jpg', '193_ohaku8.2.jpg', 'Damian Desmond', '✅ READY FOR RENT ✅\r\nDAMIAN TEENS (Spy x Family)\r\n\r\nPrice Rent 120k/3hari\r\n\r\nSize L\r\nLD 104\r\nLP 76\r\n\r\nInclude:\r\n- Costume Mengxiao (Taobao)\r\n- Wig manmei\r\n- Jubah/Cloak\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'Mengxiao', 'L', 120000.00, 'https://www.instagram.com/p/CouC1IOBJhR/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:27:22', 'aktif', 'approved', 0),
(87, 19, 3, 74, 2, 1, '191_ohaku9.jpg', '', '', 'Hibana', '✅ READY FOR RENT ✅\r\nPRINCESS HIBANA (Fire Force)\r\n\r\nPrice Rent 125k/3hari\r\n\r\nSize : All Size (fit to M-L)\r\n\r\nInclude:\r\n- Costume Freebrand Taobao\r\n- Wig RSF\r\n- Acc\r\n\r\n*DIMOHON MEMBACA RULES SEBELUM MERENTAL', 'No Brand', 'M - L', 125000.00, 'https://www.instagram.com/p/CpK11SABC4g/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:27:24', 'aktif', 'approved', 0),
(89, 20, 3, 7, 2, 1, '201_xinxin1.jpg', '202_xinxin1.1.jpg', '203_xinxin1.2.jpg', 'Xilonen', '[COMING SOON ESTIMASI FEBRUARI 2025] XILONEN GENSHIN IMPACT - LARDOO\r\n\r\nMOHON MEMBACA SnK DI HIGHLIGHT SEBELUM MERENTAL‼️\r\n\r\nSELECTIVE CUST, KHUSUS YANG PERNAH 3x RENT CHARA GAME DENGAN COS BRAND SERUPA/SANMACHIME/ICHIYO/UWOWO/DELUSION DLL. MERK LOW QUALITY SEPERTI WUDU/YYWC/FREEBRAND DLL TIDAK DIHITUNG.', 'Lardoo', 'S', 200000.00, 'https://www.instagram.com/p/C_gCRORS1i5/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:54:19', 'aktif', 'approved', 0),
(90, 20, 3, 6, 2, 1, '201_xinxin2.jpg', '202_xinxin2.1.jpg', '', 'Fu Xuan', '[COMING SOON] fuxuan size S\r\n\r\nHarga belum termasuk laundry dan repair wig sebesar 15k', 'CosplayFM', 'S', 165000.00, 'https://www.instagram.com/p/DCPFPdPSVa1/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:54:19', 'aktif', 'approved', 0),
(91, 20, 3, 6, 1, 1, '201_xinxin3.jpg', '202_xinxin3.1.jpg', '', 'Luocha', 'READY FOR RENT‼️\r\n\r\nHARGA MASIH BELUM TERMASUK LAUNDRY + CUCI WIG SEBESAR 15K.', 'Wudu', 'M', 140000.00, 'https://www.instagram.com/p/C9HMMT2ynTV/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-11 01:48:32', 'aktif', 'approved', 1),
(92, 20, 3, 76, 1, 1, '201_xinxin4.jpg', '202_xinxin4.1.jpg', '', 'Lan Wangji', 'Ready for rent! Paxel medium 1kg\r\n\r\nReal pict, bisa cek testimonii 🥰🥰\r\n\r\nMOHON MEMBACA SNK DI HIGHLIGHT BUKAN DI PINNED POST SEBELUM MERENTAL\r\n\r\nHARGA MASIH BELUM TERMASUK LAUNDRY + CUCI WIG SEBESAR 15K.\r\n', 'No Brand', 'M', 100000.00, 'https://www.instagram.com/p/C0MahAih7-E/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:54:17', 'aktif', 'approved', 0),
(93, 20, 3, 7, 999, 1, '201_xinxin5.jpg', '202_xinxin5.1.jpg', '', 'Kamisato Ayato', 'READY FOR RENT\r\n\r\n💖FIRST TIMER FRIENDLY💖\r\n\r\nPaxel medium 1kg\r\n\r\nHarap membaca S&K sebelum merental DI HIGHLIGHT BUKAN DI PINNED POST 🥰\r\n\r\nHARGA MASIH BELUM TERMASUK LAUNDRY + CUCI WIG SEBESAR 15K.', 'No Brand', 'M', 100000.00, 'https://www.instagram.com/p/C1hBJt6hCSj/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:54:20', 'aktif', 'approved', 0),
(94, 20, 3, 77, 1, 1, '201_xinxin6.jpg', '202_xinxin6.1.jpg', '', 'Hinata Shouyo', '[COMING SOON] Paxel medium 1kg\r\n\r\nMOHON MEMBACA SNK DI HIGHLIGHT SEBELUM MERENTAL‼️\r\n\r\nHARGA MASIH BELUM TERMASUK LAUNDRY + CUCI WIG SEBESAR 15K.', 'Maker Lokal', 'M', 75000.00, 'https://www.instagram.com/p/C9SScbJyEy2/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:54:17', 'aktif', 'approved', 0),
(95, 20, 3, 6, 1, 1, '201_xinxin7.jpg', '202_xinxin7.1.jpg', '', 'Gallagher', '[coming soon] gallagher - brand manluren\r\n\r\nHarga belum termasuk laundry 15k\r\n\r\nEstimasi kapan-kapan deh', 'Manluren', 'L', 125000.00, 'https://www.instagram.com/p/C-cvNGgSZHg/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:54:18', 'aktif', 'approved', 0),
(96, 20, 3, 6, 2, 1, '201_xinxin8.jpg', '202_xinxin8.1.jpg', '', 'Acheron', 'EADY FOR RENT‼️\r\n\r\nAcheron wudu + wig manmei - 125k/3days\r\n\r\nMOHON MEMBACA SNK DI HIGHLIGHT SEBELUM MERENTAL‼️\r\n\r\nharga belum termasuk laundry + repair wig 15k', 'Wudu', 'S', 125000.00, 'https://www.instagram.com/p/DATOxJ3SGGG/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:58:19', 'aktif', 'approved', 0),
(97, 20, 3, 6, 999, 1, '201_xinxin9.jpg', '202_xinxin9.1.jpg', '203_xinxin9.2.jpg', 'Misha', 'READY FOR RENT‼️\r\n\r\nMisha Honkai Star Rail - BRAND SANMACHIME (Wig semi hard style brand Manmei)\r\n\r\nMOHON BACA SNK DI HIGHLIGHT BUKAN DI PINNED POST SEBELUM MERENTAL‼️‼️‼️\r\n\r\nHARGA MASIH BELUM TERMASUK LAUNDRY + CUCI WIG SEBESAR 15K.\r\n\r\nMINIMAL PENGALAMAN RENTAL 2x DAN TIDAK PERNAH TERLIBAT MASALH DENGAN TOKO RENTALAN SEBELUMNYA‼️', 'Sanmachime / NTS', 'M', 180000.00, 'https://www.instagram.com/p/C7eaTRCBnaA/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 19:58:20', 'aktif', 'approved', 0),
(98, 21, 3, 27, 1, 1, '211_savoyu1.jpg', '212_savoyu1.1.jpg', '213_savoyu1.2.jpg', 'Monkey D. Luffy', '😻 READY FOR RENT 😻\r\n🐾LUFFY EGGHEAD ARC - One Piece 🐾\r\n\r\nHarga sewa : 165k\r\n+Cover boots 45k\r\n\r\nCostume: CosplayFm\r\nWig: Manmei\r\nInclude: costume, wig & acc\r\nALL SIZE\r\nLd max 102cm\r\n\r\nUkuran paket:\r\nCostume & acc + wig : large\r\n\r\n------------------------------------------------------------------------------------------\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg hitam/cream 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'CosplayFM', 'All size', 160000.00, 'https://www.instagram.com/p/C_p1mpUBVdM/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:19:10', 'aktif', 'approved', 0),
(99, 21, 3, 27, 2, 1, '211_savoyu2.jpg', '212_savoyu2.1.jpg', '213_savoyu2.2.jpg', 'Nico Robin', '😻 READY FOR RENT 😻\r\n🐾NICOROBIN - One Piece (Egghead Arc)🐾\r\n\r\nHarga sewa : 185k\r\n+45k coverboots\r\n\r\nCostume: CosplayFm\r\nWig: Doki-Doki\r\n\r\nInclude: costume, wig, & acc\r\n\r\nLingkar dada : 89-92cm\r\nLingkar pinggang : 70-74cm\r\nUkuran paket:\r\n\r\nCostume & acc + wig :\r\n\r\n------------------------------------------------------------------------------------------\r\n\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n\r\n⭐ Pantyhose sheleg hitam/cream 10k/pcs\r\n\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n\r\n⭐ Transparan strap bra +5k/pasang\r\n\r\n*Selama persediaan masih ada\r\n\r\n*Harga sewaktu-waktu dapat berubah', 'CosplayFM', 'S - M', 185000.00, 'https://www.instagram.com/p/DAX-9oky2zJ/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:19:11', 'aktif', 'approved', 0),
(100, 21, 3, 27, 2, 1, '211_savoyu3.jpg', '212_savoyu3.1.jpg', '213_savoyu3.2.jpg', 'Nami', '😻 READY FOR RENT 😻\r\n\r\n🐾 NAMI WANO ARC - ONE PIECE 🐾\r\n\r\nHarga sewa : 70k\r\n\r\nCostume : import taobao\r\nWig : dokidoki\r\nInclude: costume + wig + acc\r\nLd : up to\r\nLp: up to\r\n\r\nUkuran paket:\r\nCostume & acc + wig :\r\nBerat :\r\n\r\n------------------------------------------------------------------------------------------\r\n\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'No Brand', 'All size', 70000.00, 'https://www.instagram.com/p/C7ZAkyUB3fC/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:19:12', 'aktif', 'approved', 0),
(101, 21, 3, 27, 2, 1, '211_savoyu4.jpg', '212_savoyu4.1.jpg', '213_savoyu4.2.jpg', 'Vegapunk / Lilith', '😻 READY FOR RENT 😻\r\n\r\n🐾Lilith PUNK 02 - One piece🐾\r\n\r\nHarga sewa : 185k\r\n+Cover boots 45k\r\n\r\nCostume: CosplayFm\r\nWig: Manmei\r\nInclude: costume, wig & acc\r\n\r\nSize manekin S (ld 82 lp 60)\r\nSize costume size M aslinya tapi inner latexnya gak terlalu melar\r\nReal size (diukur manual)\r\nLd 88\r\nLp 68\r\nSize menurut size chart katalog\r\nLd 89-92\r\nLp 72-75\r\n\r\nUkuran paket:\r\nCostume & acc + wig : large\r\n\r\n------------------------------------------------------------------------------------------\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg hitam/cream 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'CosplayFM', 'S - M', 185000.00, 'https://www.instagram.com/p/C-P8rfhzFf6/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:19:13', 'aktif', 'approved', 0),
(102, 21, 3, 7, 2, 1, '211_savoyu5.jpg', '212_savoyu5.1.jpg', '213_savoyu5.2.jpg', 'Sigewinne', '😻 READY FOR RENT 😻\r\n\r\n🐾 SIGEWINNE- Genshin Impact🐾\r\nHarga sewa : 165k\r\n\r\nCostume: Monenjoy\r\nWig: Manmei\r\nInclude: costume, wig, & acc\r\nWajib menggunakan kaos kaki milik sendiri saat menggunakan costume\r\n\r\nLingkar dada : 90-95cm\r\nLingkar pinggang : 72-75cm\r\nLingkat panggul : 98cm\r\nLingkar paha : 49cm\r\nPanjang celana : 40cm\r\n\r\nUkuran paket:\r\nPaxel dengan kardus large\r\nPaxel dengan koper 16inch 42x30x20cm large\r\nPacking kardus ekspedisi 2.65kg\r\nPackaging dengan koper 16inch 4,15kg\r\n\r\nCATATAN‼️\r\nNote: menghilangkan/merusak acc dan merusak/menghilangkan kostume mid to high brand harus mengganti acc/part/kostume sesuai brand jika tidak dapat acc/part/kostume sesuai brand tersebut maka membuatkan acc/part kostume dengan maker & dikenakan denda tambahan (350k-1000k/ganti sesuai brand)* tergantung acc/part/kostume yg dihilangkan/dirusak.\r\n\r\n*Diberikan denda tersebut karena acc/part kostume original brand yg hilang/rusak dapat menurunkan drastis harga jual costume tersebut.\r\n\r\n------------------------------------------------------------------------------------------\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg hitam/cream 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'Monenjoy', 'XL', 165000.00, 'https://www.instagram.com/p/C3ohE3gBxvm/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:19:13', 'aktif', 'approved', 0),
(103, 21, 3, 6, 1, 1, '211_savoyu6.jpg', '212_savoyu6.1.jpg', '213_savoyu6.2.jpg', 'Caelus', '😻 READY FOR RENT 😻\r\n\r\nCAELUS\r\nHonkai Star Rail\r\n\r\nHarga sewa : 100k\r\n\r\nCostume: Import Taobao Dianpu Yinxiang\r\nWig: Manmei\r\nInclude: costume (kaos putih,jubah & celana), wig & acc (sarung tangan & tali pinggang)\r\n\r\nLd: maxsimal 120cm\r\nLp: 92-100cm\r\nLingkar panggul: 116cm\r\nLingkar paha: 62cm\r\n\r\nUkuran paket:\r\nCostume & acc + wig : Medium\r\n\r\n------------------------------------------------------------------------------------------\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg hitam/cream 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'Dianpu Yinxiang', 'XXXL', 100000.00, 'https://www.instagram.com/p/C2AGlIRBXUF/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:19:11', 'aktif', 'approved', 0),
(104, 21, 3, 27, 2, 1, '211_savoyu7.jpg', '212_savoyu7.1.jpg', '213_savoyu7.2.jpg', 'Nami', '😻 READY FOR RENT 😻\r\n🐾Nami - One Piece (Egghead Arc)🐾\r\n\r\nHarga sewa : 165k\r\n+45k coverboots\r\n\r\nCostume: CosplayFm\r\nWig: Doki-Doki\r\n\r\nInclude: costume, wig, & acc\r\n\r\nLingkar dada : 89-92cm\r\nLingkar pinggang : 70-74cm\r\nUkuran paket:\r\n\r\nCostume & acc + wig :\r\n\r\n------------------------------------------------------------------------------------------\r\n\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg hitam/cream 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'CosplayFM', 'S - M', 165000.00, 'https://www.instagram.com/p/DAVvmrCS8Mx/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:19:14', 'aktif', 'approved', 0),
(105, 21, 3, 78, 2, 1, '211_savoyu8.jpg', '212_savoyu8.1.jpg', '213_savoyu8.2.jpg', 'Megumin', '😻 READY FOR RENT 😻\r\n\r\n🐾MEGUMIN - Konosuba🐾\r\n\r\nHarga sewa : 100k\r\n\r\nCostume : Cosplayfm\r\nWig : Manmei\r\nInclude: costume (baju & jubah) + wig + acc (topi, tali pinggang, penutup mata & acc kaki kanan kiri)\r\nLd : up to 95cm\r\nLp: up to 74cm\r\n\r\nUkuran paket:\r\nCostume & acc + wig : Medium\r\nBerat + packing 1,9kg\r\n\r\n------------------------------------------------------------------------------------------\r\n\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'CosplayFM', 'M', 100000.00, 'https://www.instagram.com/p/CzSnLtKhjMk/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:24:07', 'aktif', 'approved', 0),
(106, 21, 3, 7, 2, 1, '211_savoyu9.jpg', '212_savoyu9.1.jpg', '213_savoyu9.2.jpg', 'Kirara', '😻 READY FOR RENT 😻\r\n\r\n🐾KIRARA - Genshin Impact🐾\r\nHarga sewa : 135k\r\n\r\nCostume: Wudu\r\nWig: Manmei\r\nInclude: costume, wig, sandal & acc\r\n\r\nLd: up to 96cm\r\nLp: up to 84cm\r\nSandal : size 39-40\r\n\r\nUkuran paket:\r\nPaxel\r\nCostume & acc + wig : Medium\r\nCostume & acc + wig + sandal : large\r\nCostume & acc + wig : 2kg\r\nCostume & acc + wig + sandal : 2,4kg\r\n------------------------------------------------------------------------------------------\r\nKami juga menyediakan berbagai keperluan untuk cosplay, seperti:\r\n⭐ Pantyhose apple cream/hitam +27k/pcs\r\n⭐ Pantyhose sheleg hitam/cream 10k/pcs\r\n⭐ Wig cap jaring hitam/cream +5k/pcs\r\n⭐ Transparan strap bra +5k/pasang\r\n*Selama persediaan masih ada\r\n*Harga sewaktu-waktu dapat berubah', 'Wudu', 'XL', 135000.00, 'https://www.instagram.com/p/C2G7_rGB0tK/?utm_source=ig_web_copy_link&igsh=MzRlODBiNWFlZA==', 3, '2024-12-11', '2024-12-10 20:24:08', 'aktif', 'approved', 0),
(107, 16, 3, 7, 1, 1, '161_jSGe9ODFA5roXblRA7R0.webp', '162_Hp3iUQSElisae2S2O23o.webp', '', 'Zhongli Emperor', 'Zhongli Emperor\r\n\r\nXSF , wig manmei size L\r\n\r\n100 k / 3 hari\r\n\r\nDM IG FOR BOOKING !', 'XSF', 'L', 100000.00, 'https://www.instagram.com/p/DC4VNmvSBr2/?next=%2F&img_index=1', 3, '2024-12-11', '2024-12-11 06:35:12', 'aktif', 'approved', 0),
(108, 16, 3, 6, 2, 2, '161_s6VYMTvc5u3bPXoQtZvA.webp', '', '', 'Lingsha', 'Lingsha HSR\r\n\r\nsize L brand wudu\r\n\r\n130 k / 3 hari\r\n\r\nDM @ayami_rent for booking and details !', 'Wudu', 'L', 130000.00, '', 3, '2024-12-11', '2024-12-11 07:14:22', 'aktif', 'approved', 0),
(109, 24, 3, 1, 1, 2, '241_s6VYMTvc5u3bPXoQtZvA.webp', '', '', 'naruto', 'asdasdas', 'wudu', 'XL', 100000.00, 'https://www.instagram.com/p/DC4VNmvSBr2/?next=%2F&img_index=1', 3, '2024-12-11', '2024-12-11 12:45:42', 'aktif', 'approved', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tb_gender`
--

CREATE TABLE `tb_gender` (
  `id_gender` int(11) NOT NULL,
  `gender` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_gender`
--

INSERT INTO `tb_gender` (`id_gender`, `gender`) VALUES
(1, 'Male'),
(2, 'Female'),
(999, 'Unisex\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kat` int(11) NOT NULL,
  `kat_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kat`, `kat_name`) VALUES
(3, 'Costume'),
(4, 'Wig'),
(5, 'Weapon'),
(6, 'Accessories'),
(7, 'Add On');

-- --------------------------------------------------------

--
-- Table structure for table `tb_media`
--

CREATE TABLE `tb_media` (
  `id_media` int(11) NOT NULL,
  `media_name` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_media`
--

INSERT INTO `tb_media` (`id_media`, `media_name`) VALUES
(1, 'Anime'),
(2, 'Game'),
(3, 'Manhwa'),
(4, 'Comic'),
(5, 'Movie'),
(6, 'Film'),
(7, 'TV Series'),
(8, 'Manhua'),
(9, 'Manga'),
(10, 'Novel'),
(11, 'Vocaloid'),
(12, 'V-tuber');

-- --------------------------------------------------------

--
-- Table structure for table `tb_owner`
--

CREATE TABLE `tb_owner` (
  `id_owner` int(11) NOT NULL,
  `owner_name` varchar(100) NOT NULL,
  `ig` varchar(100) DEFAULT NULL,
  `desc` text DEFAULT NULL,
  `no_telp` varchar(15) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(100) NOT NULL,
  `address` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `foto` varchar(100) NOT NULL,
  `status` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_owner`
--

INSERT INTO `tb_owner` (`id_owner`, `owner_name`, `ig`, `desc`, `no_telp`, `email`, `password`, `address`, `created_at`, `foto`, `status`) VALUES
(16, 'Ayami Rent', 'ayami_rent', 'Rental Cosplay Bandung\r\n📍Bandung, Pasir Impun Atas\r\nBisa keluar Jawa! dan bisa dadakan khusus bandung.\r\n🚚: Paxel, JNE, Go-send, Lionparcel\r\nowner:\r\n@ayyaayey\r\n@jejewemy', '-', 'ayamirent@gmail.com', '$2y$10$LKdgWtUPanDP3fRfxfoj8OneDqzjeX9pJBpo68gW4jKImmFs9ri26', 'Bandung, Pasir Impun Atas', '2024-12-10 01:25:15', '20241210082515_5963.webp', 'aktif'),
(17, 'Ukii Cosrent', 'ukii.cosrent', 'Rental Cosplay Wig & Hijab - Kab. Malang\r\nKebun Binatang Jinak\r\nWEEKEND SLOWRESPON ‼️\r\n❌ TIDAK PUNYA SELAIN DI POSTINGAN🥰\r\n😔 Baca dulu SNK & ALUR Rent\r\n🏝 Pulau JAWA-BANTEN Bisa Rent~\r\n✨ Bisa sewa weekdays\r\n📍 UKII COSRENT, Jl. Kartanegara No.81, Pagentan, Singosari, Malang 65153\r\nukiicosplayrent.carrd.co', '-', 'ukiicosrent@gmail.com', '$2y$10$Q67D/TMPcg1q10PfitCU6uQaLgZSUqj2Ex8VG8eJ8UAKXlDDHnuw2', 'UKII COSRENT, Jl. Kartanegara No.81, Pagentan, Singosari, Malang 65153', '2024-12-10 01:57:46', '20241210085746_3890.webp', 'aktif'),
(18, 'noen.cosrent', 'noen.cosrent', 'RENTAL COSPLAY dan STYLING WIG MALANG JATIM (M-XL)\r\nPakaian (Merek)\r\n🚫 AKUN NORMIES 🚫\r\n✂️Styling & Repair Wig Jawa Timur\r\n💕Size M-XL\r\n💰Qris, BCA, BRI, E-wallet\r\n📍Belakang UIN, Lowokwaru, Malang', '-', 'noencosrent@gmail.com', '$2y$10$DBwPKvlL62BsoKhRv80j7eMw4B0WCOPUwxLP0XwdbjQqLmS44TCOK', 'Belakang UIN, Lowokwaru, Malang', '2024-12-10 02:21:42', '20241210092142_2390.webp', 'aktif'),
(19, 'OHAKU RENTCOS', 'ohaku_rentcos', 'Rental Cosplay Surabaya\r\nTempat Persewaan\r\n🏠 SURABAYA, Jawa Timur\r\n🏠 SALATIGA @ohaku_x3rentcos\r\n🗨 Sabtu & Minggu Slow Respon\r\n📦 RENT ONLY AREA JAWA & BALI\r\n⬇️ SEBELUM RENT WAJIB BACA LINK INI\r\nbit.ly/ohakurentcos', '-', 'ohakurentcos@gmail.com', '$2y$10$Js4OiNqMqkzbUhuYxChVuu4HrCtDoNpz6AOfmkB949PjzSG1lWJIa', 'SURABAYA, Jawa Timur', '2024-12-10 12:59:29', '20241210195929_2867.webp', 'aktif'),
(20, 'MinXin', 'xinxin.cosurent', '[Minxin] rental cosplay anime danmei bogor\r\nToko Kostum\r\nOpen 09.00 - 22.00\r\nLuar pulau CEK SNK DULU\r\nREAD SNK & SCHEDULE ON HIGHLIGHT FIRST‼️\r\nHandled by 3 admins\r\n📍 Tanah Sereal & Cibinong', '-', 'xinxin@gmail.com', '$2y$10$69GU6ziQoT1O9RGbGd1ugOJBDWckp5K2aV5FDf25nULhHDRsRvaZq', 'Tanah Sereal & Cibinong', '2024-12-10 13:30:18', '20241210203018_1066.webp', 'aktif'),
(21, 'Savoyurentcos', 'Savoyurentcos', 'RENTAL COSTUME COSPLAY SAVOYU\r\n📍Cempaka Putih,JAKPUS\r\nTidak bisa dm ➡️ komen dipostingan\r\nRent weekday👍 Luar pulau👍\r\n🧐MENYEWA=MENYETUJUI S&K‼️', '-', 'savoyu@gmail.com', '$2y$10$mZ.1IAL/DreIVHmuhnpcTu11Wrln5Rj9SuOiSIqst8tM.A5j89yFS', 'Cempaka Putih,JAKPUS', '2024-12-10 14:01:41', '20241210210141_2007.webp', 'aktif'),
(22, 'cuanturu.cosrent', 'cuanturu.cosrent', '', '-', 'cuanturu@cosrent.com', '$2y$10$7n3Mb.xUownez93c.tsw2ecwfzD2Eji2F/eLliJ8/DVMDWAnmocj.', '', '2024-12-10 22:49:20', '20241211054920_4177.jpg', 'aktif'),
(24, 'hanjoy.cosrent', 'hanjoy.cosrent', '', '_', 'hanjoy.cosrent@g.l', '$2y$10$F6e245vfgGWLGLTG5tw5weMwt6PREjkrouXmrz6pSgtgZ9dFVIHHu', '', '2024-12-11 06:43:13', '20241211134313_8427.jpg', 'aktif');

-- --------------------------------------------------------

--
-- Table structure for table `tb_series`
--

CREATE TABLE `tb_series` (
  `id_series` int(11) NOT NULL,
  `id_media` int(11) NOT NULL,
  `series_name` varchar(100) NOT NULL,
  `s_image` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_series`
--

INSERT INTO `tb_series` (`id_series`, `id_media`, `series_name`, `s_image`) VALUES
(1, 1, 'Naruto', 'https://c4.wallpaperflare.com/wallpaper/672/578/501/manga-naruto-shippuuden-uzumaki-naruto-uchiha-sasuke-wallpaper-preview.jpg'),
(2, 2, 'Final Fantasy', 'https://c4.wallpaperflare.com/wallpaper/905/1014/395/cloud-strife-tifa-lockhart-final-fantasy-vii-vihttps://c4.wallpaperflare.com/wallpaper/323/37/211/final-fantasy-vii-remake-tifa-lockhart-final-fantasy-vii-hd-wallpaper-preview.jpg'),
(3, 3, 'Solo Leveling', 'https://c4.wallpaperflare.com/wallpaper/865/301/276/anime-solo-leveling-sung-jin-woo-hd-wallpaper-pr'),
(4, 4, 'Batman', 'https://c4.wallpaperflare.com/wallpaper/420/10/333/batman-arkham-knight-wallpaper-preview.jpg'),
(5, 5, 'Star Wars', 'https://c4.wallpaperflare.com/wallpaper/231/936/951/star-wars-star-wars-the-force-awakens-stormtroop'),
(6, 2, 'Honkai Star Rail', 'https://c4.wallpaperflare.com/wallpaper/343/262/557/honkai-star-rail-march-7th-honkai-star-rail-hd-wallpaper-preview.jpg'),
(7, 2, 'Genshin Impact', 'https://c4.wallpaperflare.com/wallpaper/14/212/894/genshin-impact-raiden-shogun-genshin-impact-yae-miko-genshin-impact-anime-games-vysakhjanan-hd-wallpaper-preview.jpg'),
(8, 1, 'Frieren', 'https://c4.wallpaperflare.com/wallpaper/691/264/1010/sousou-no-frieren-frieren-heiter-sousou-no-frie'),
(9, 1, 'Kimetsu No Yaiba', 'https://c4.wallpaperflare.com/wallpaper/869/512/849/anime-demon-slayer-kimetsu-no-yaiba-zenitsu-agatsuma-hd-wallpaper-preview.jpg'),
(10, 2, 'Zenless Zone Zero', 'https://c4.wallpaperflare.com/wallpaper/568/538/521/zenless-zone-zero-artwork-nicole-demara-zenless-zone-zero-anime-anime-girls-hd-wallpaper-preview.jpg'),
(11, 2, 'NIKKE', 'https://c4.wallpaperflare.com/wallpaper/786/197/296/anime-anime-girls-women-trio-nikke-the-goddess-o'),
(12, 1, 'Cyberpunk Edgerunners', 'https://c4.wallpaperflare.com/wallpaper/920/1010/358/cyberpunk-edgerunners-cyberpunk-2077-cyberpunk-netflix-anime-hd-wallpaper-preview.jpg'),
(13, 11, 'Vocaloid s1', 'https://c4.wallpaperflare.com/wallpaper/245/793/312/anime-hatsune-miku-vocaloid-anime-girls-wallpaper-preview.jpg'),
(14, 12, 'V-Tuber', 'https://c4.wallpaperflare.com/wallpaper/79/810/502/lam-inugami-korone-vtubers-digital-art-artwork-hd-wallpaper-preview.jpg'),
(15, 5, 'Spirited Away', 'https://c4.wallpaperflare.com/wallpaper/811/305/866/studio-ghibli-spirited-away-chihiro-ogino-haku-hd-wallpaper-preview.jpg'),
(16, 5, 'Your Name (Kimi no Na wa)', 'https://c4.wallpaperflare.com/wallpaper/371/627/840/anime-your-name-mitsuha-miyamizu-taki-tachibana-wallpaper-preview.jpg'),
(17, 5, 'Weathering With You', 'https://c4.wallpaperflare.com/wallpaper/684/396/926/anime-weathering-with-you-wallpaper-preview.jpg'),
(18, 5, 'Howl\'s Moving Castle', 'https://c4.wallpaperflare.com/wallpaper/134/518/1009/studio-ghibli-howls-moving-castle-anime-wallpaper-preview.jpg'),
(19, 5, 'Princess Mononoke', 'https://c4.wallpaperflare.com/wallpaper/164/775/918/studio-ghibli-princess-mononoke-samurai-wallpaper-preview.jpg'),
(20, 1, 'Attack on Titan', 'https://c4.wallpaperflare.com/wallpaper/127/13/720/anime-attack-on-titan-eren-yeager-mikasa-ackerman-wallpaper-preview.jpg'),
(21, 8, 'Soul Land', 'https://c4.wallpaperflare.com/wallpaper/26/134/720/soul-land-anime-3d-wallpaper-preview.jpg'),
(22, 8, 'Tales of Demons and Gods', 'https://c4.wallpaperflare.com/wallpaper/649/730/223/tales-of-demons-and-gods-nie-li-anime-wallpaper-preview.jpg'),
(23, 7, 'Stranger Things', 'https://c4.wallpaperflare.com/wallpaper/23/90/905/tv-stranger-things-netflix-wallpaper-preview.jpg'),
(24, 5, 'The Lion King', 'https://c4.wallpaperflare.com/wallpaper/1014/757/230/the-lion-king-disney-wallpaper-preview.jpg'),
(25, 5, 'Frozen', 'https://c4.wallpaperflare.com/wallpaper/552/982/90/frozen-anna-elsa-disney-wallpaper-preview.jpg'),
(26, 3, 'The Beginning After the End', 'https://c4.wallpaperflare.com/wallpaper/360/270/579/the-beginning-after-the-end-tbte-manhwa-wallpaper-preview.jpg'),
(27, 9, 'One Piece', 'https://c4.wallpaperflare.com/wallpaper/415/827/811/anime-one-piece-wallpaper-preview.jpg'),
(28, 9, 'Bleach', 'https://c4.wallpaperflare.com/wallpaper/923/304/659/bleach-anime-hd-wallpaper-preview.jpg'),
(29, 9, 'Dragon Ball', 'https://c4.wallpaperflare.com/wallpaper/702/730/539/dragon-ball-anime-goku-hd-wallpaper-preview.jpg'),
(30, 6, 'Inception', 'https://c4.wallpaperflare.com/wallpaper/692/218/682/movie-inception-wallpaper-preview.jpg'),
(31, 6, 'Interstellar', 'https://c4.wallpaperflare.com/wallpaper/281/1013/701/interstellar-space-outer-space-wallpaper-preview.jpg'),
(32, 10, 'Harry Potter', 'https://c4.wallpaperflare.com/wallpaper/435/850/519/harry-potter-harry-potter-characters-poster-wallpaper-preview.jpg'),
(33, 10, 'The Lord of the Rings', 'https://c4.wallpaperflare.com/wallpaper/3/330/933/the-lord-of-the-rings-movie-wallpaper-preview.jpg'),
(34, 12, 'Hololive', 'https://c4.wallpaperflare.com/wallpaper/192/289/280/anime-anime-girls-hololive-gawr-gura-ninomae-ina-nis-hd-wallpaper-preview.jpg'),
(35, 5, 'A Silent Voice (Koe no Katachi)', 'https://c4.wallpaperflare.com/wallpaper/828/782/694/anime-a-silent-voice-shouya-ishida-shouko-nishimiya-wallpaper-preview.jpg'),
(36, 5, 'The Girl Who Leapt Through Time', 'https://c4.wallpaperflare.com/wallpaper/173/120/27/anime-the-girl-who-leapt-through-time-hd-wallpaper-preview.jpg'),
(37, 5, 'My Neighbor Totoro', 'https://c4.wallpaperflare.com/wallpaper/849/124/751/studio-ghibli-my-neighbor-totoro-anime-wallpaper-preview.jpg'),
(38, 5, 'Castle in the Sky', 'https://c4.wallpaperflare.com/wallpaper/192/898/209/studio-ghibli-castle-in-the-sky-anime-wallpaper-preview.jpg'),
(39, 5, 'Ponyo', 'https://c4.wallpaperflare.com/wallpaper/211/525/332/ponyo-studio-ghibli-hayao-miyazaki-wallpaper-preview.jpg'),
(40, 9, 'Death Note', 'https://c4.wallpaperflare.com/wallpaper/867/378/745/anime-death-note-light-yagami-ryuk-wallpaper-preview.jpg'),
(41, 9, 'Fairy Tail', 'https://c4.wallpaperflare.com/wallpaper/55/878/430/fairy-tail-anime-natsu-dragneel-lucy-heartfilia-wallpaper-preview.jpg'),
(42, 9, 'Hunter x Hunter', 'https://c4.wallpaperflare.com/wallpaper/978/973/286/anime-hunter-x-hunter-gon-freecss-killua-zoldyck-wallpaper-preview.jpg'),
(43, 9, 'Tokyo Ghoul', 'https://c4.wallpaperflare.com/wallpaper/760/258/404/anime-tokyo-ghoul-ken-kaneki-wallpaper-preview.jpg'),
(44, 9, 'Black Clover', 'https://c4.wallpaperflare.com/wallpaper/531/563/19/asta-black-clover-anime-wallpaper-preview.jpg'),
(45, 3, 'Tower of God', 'https://c4.wallpaperflare.com/wallpaper/886/965/911/tower-of-god-anime-boy-light-hd-wallpaper-preview.jpg'),
(46, 3, 'Omniscient Reader’s Viewpoint', 'https://c4.wallpaperflare.com/wallpaper/308/108/973/omniscient-reader-s-viewpoint-kim-dokja-wallpaper-preview.jpg'),
(47, 3, 'The God of High School', 'https://c4.wallpaperflare.com/wallpaper/548/809/467/the-god-of-high-school-anime-jin-mori-wallpaper-preview.jpg'),
(48, 2, 'The Legend of Zelda', 'https://c4.wallpaperflare.com/wallpaper/960/927/463/the-legend-of-zelda-breath-of-the-wild-wallpaper-preview.jpg'),
(49, 2, 'Elden Ring', 'https://c4.wallpaperflare.com/wallpaper/949/686/577/elden-ring-game-hd-wallpaper-preview.jpg'),
(50, 2, 'Overwatch', 'https://c4.wallpaperflare.com/wallpaper/174/92/49/overwatch-d-va-tracer-hd-wallpaper-preview.jpg'),
(51, 2, 'League of Legends', 'https://c4.wallpaperflare.com/wallpaper/527/167/977/league-of-legends-anime-girls-wallpaper-preview.jpg'),
(52, 2, 'World of Warcraft', 'https://c4.wallpaperflare.com/wallpaper/662/927/60/world-of-warcraft-game-wallpaper-preview.jpg'),
(53, 7, 'Game of Thrones', 'https://c4.wallpaperflare.com/wallpaper/644/843/716/game-of-thrones-tv-show-wallpaper-preview.jpg'),
(54, 7, 'The Witcher', 'https://c4.wallpaperflare.com/wallpaper/69/844/482/the-witcher-tv-series-wallpaper-preview.jpg'),
(55, 7, 'Breaking Bad', 'https://c4.wallpaperflare.com/wallpaper/730/146/29/breaking-bad-wallpaper-preview.jpg'),
(56, 7, 'The Mandalorian', 'https://c4.wallpaperflare.com/wallpaper/370/204/119/the-mandalorian-star-wars-tv-series-wallpaper-preview.jpg'),
(57, 7, 'Dark', 'https://c4.wallpaperflare.com/wallpaper/139/424/807/dark-netflix-series-wallpaper-preview.jpg'),
(58, 10, 'Percy Jackson & the Olympians', 'https://c4.wallpaperflare.com/wallpaper/314/279/385/percy-jackson-book-series-wallpaper-preview.jpg'),
(59, 10, 'The Hunger Games', 'https://c4.wallpaperflare.com/wallpaper/545/126/840/the-hunger-games-wallpaper-preview.jpg'),
(60, 10, 'Dune', 'https://c4.wallpaperflare.com/wallpaper/259/347/497/dune-frank-herbert-novel-wallpaper-preview.jpg'),
(61, 10, 'Sherlock Holmes', 'https://c4.wallpaperflare.com/wallpaper/576/683/331/sherlock-holmes-book-cover-wallpaper-preview.jpg'),
(67, 1, 'Jujutsu Kaisen', 'https://c4.wallpaperflare.com/wallpaper/70/1016/58/anime-anime-boys-jujutsu-kaisen-yuji-itadori-sakuna-hd-wallpaper-preview.jpg'),
(68, 1, 'Utaite', 'https://c4.wallpaperflare.com/wallpaper/14/418/412/mafumafu-utaite-white-hair-red-eyes-wallpaper-preview.jpg'),
(69, 1, 'Project Sekai', 'https://c4.wallpaperflare.com/wallpaper/544/428/3/haliya-hatsune-miku-project-sekai-colorful-stage-feat-hatsune-miku-carousel-hd-wallpaper-preview.jpg'),
(70, 9, 'Oshi No Ko', 'https://c4.wallpaperflare.com/wallpaper/417/631/648/dinocozero-collage-ai-hoshino-oshi-no-ko-anime-girls-hd-wallpaper-preview.jpg'),
(71, 1, 'Darling in the Franxx', 'https://c4.wallpaperflare.com/wallpaper/250/436/1020/darling-in-the-franxx-code-016-hiro-zero-two-darling-in-the-franxx-code-002-wallpaper-preview.jpg'),
(72, 1, 'Spy x Family', 'https://c4.wallpaperflare.com/wallpaper/576/415/675/spy-x-family-anime-girls-hd-wallpaper-preview.jpg'),
(73, 2, 'Valorant', 'https://c4.wallpaperflare.com/wallpaper/200/159/643/valorant-video-game-art-pc-gaming-anime-platinum-conception-s-hd-wallpaper-preview.jpg'),
(74, 9, 'Fire Force', 'https://c4.wallpaperflare.com/wallpaper/1006/350/432/anime-fire-force-shinra-kusakabe-hd-wallpaper-preview.jpg'),
(75, 1, ' My Dress Up Darling', 'https://c4.wallpaperflare.com/wallpaper/843/874/363/kitagawa-marin-my-dress-up-darling-anime-girls-hd-wallpaper-preview.jpg'),
(76, 1, 'Mo Dao Zu Shi ', 'https://c4.wallpaperflare.com/wallpaper/865/488/854/anime-mo-dao-zu-shi-hd-wallpaper-preview.jpg'),
(77, 1, 'Haikyuu!!', 'https://c4.wallpaperflare.com/wallpaper/477/1015/707/haikyuu-anime-boys-hinata-shouyou-manga-wallpaper-preview.jpg'),
(78, 1, 'Kono Subarashii Sekai ni Shukufuku wo!', 'https://c4.wallpaperflare.com/wallpaper/893/794/476/kono-subarashii-sekai-ni-shukufuku-wo-megumin-konosuba-darkness-konosuba-aqua-konosuba-kazuma-hd-wallpaper-preview.jpg'),
(79, 1, 'Yuru Camp Season 2', 'https://c4.wallpaperflare.com/wallpaper/54/477/196/aoi-camp-chiaki-ena-wallpaper-preview.jpg'),
(80, 1, 'Blue Lock', 'https://c4.wallpaperflare.com/wallpaper/95/850/381/blue-lock-%E3%83%96%E3%83%AB%E3%83%BC%E3%83%AD%E3%83%83%E3%82%AF-anime-soccer-hd-wallpaper-preview.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `tb_status`
--

CREATE TABLE `tb_status` (
  `id_status` int(11) NOT NULL,
  `status` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `tb_status`
--

INSERT INTO `tb_status` (`id_status`, `status`) VALUES
(1, 'Available'),
(2, 'Booked'),
(3, 'Coming Soon');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_admin`
--
ALTER TABLE `tb_admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `tb_costume`
--
ALTER TABLE `tb_costume`
  ADD PRIMARY KEY (`id_cos`),
  ADD KEY `id_kat` (`id_kat`),
  ADD KEY `id_owner` (`id_owner`),
  ADD KEY `id_gender` (`id_gender`),
  ADD KEY `id_series` (`id_series`),
  ADD KEY `id_status` (`id_status`);

--
-- Indexes for table `tb_gender`
--
ALTER TABLE `tb_gender`
  ADD PRIMARY KEY (`id_gender`);

--
-- Indexes for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kat`);

--
-- Indexes for table `tb_media`
--
ALTER TABLE `tb_media`
  ADD PRIMARY KEY (`id_media`);

--
-- Indexes for table `tb_owner`
--
ALTER TABLE `tb_owner`
  ADD PRIMARY KEY (`id_owner`);

--
-- Indexes for table `tb_series`
--
ALTER TABLE `tb_series`
  ADD PRIMARY KEY (`id_series`),
  ADD KEY `fk_media` (`id_media`);

--
-- Indexes for table `tb_status`
--
ALTER TABLE `tb_status`
  ADD PRIMARY KEY (`id_status`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_admin`
--
ALTER TABLE `tb_admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tb_costume`
--
ALTER TABLE `tb_costume`
  MODIFY `id_cos` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=110;

--
-- AUTO_INCREMENT for table `tb_gender`
--
ALTER TABLE `tb_gender`
  MODIFY `id_gender` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1001;

--
-- AUTO_INCREMENT for table `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `tb_media`
--
ALTER TABLE `tb_media`
  MODIFY `id_media` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tb_owner`
--
ALTER TABLE `tb_owner`
  MODIFY `id_owner` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `tb_series`
--
ALTER TABLE `tb_series`
  MODIFY `id_series` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- AUTO_INCREMENT for table `tb_status`
--
ALTER TABLE `tb_status`
  MODIFY `id_status` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tb_costume`
--
ALTER TABLE `tb_costume`
  ADD CONSTRAINT `tb_costume_ibfk_1` FOREIGN KEY (`id_gender`) REFERENCES `tb_gender` (`id_gender`),
  ADD CONSTRAINT `tb_costume_ibfk_2` FOREIGN KEY (`id_kat`) REFERENCES `tb_kategori` (`id_kat`),
  ADD CONSTRAINT `tb_costume_ibfk_4` FOREIGN KEY (`id_owner`) REFERENCES `tb_owner` (`id_owner`),
  ADD CONSTRAINT `tb_costume_ibfk_5` FOREIGN KEY (`id_series`) REFERENCES `tb_series` (`id_series`),
  ADD CONSTRAINT `tb_costume_ibfk_6` FOREIGN KEY (`id_status`) REFERENCES `tb_status` (`id_status`);

--
-- Constraints for table `tb_series`
--
ALTER TABLE `tb_series`
  ADD CONSTRAINT `tb_series_ibfk_1` FOREIGN KEY (`id_media`) REFERENCES `tb_media` (`id_media`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
