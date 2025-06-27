-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 09, 2025 at 12:50 PM
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
-- Database: `elektronik_rumah`
--
CREATE DATABASE IF NOT EXISTS `elektronik_rumah` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `elektronik_rumah`;

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) NOT NULL,
  `value` mediumtext NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) NOT NULL,
  `owner` varchar(255) NOT NULL,
  `expiration` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `hasil_analisis`
--

CREATE TABLE `hasil_analisis` (
  `id_analisis` int(11) NOT NULL,
  `user_id` int(20) UNSIGNED NOT NULL,
  `riwayat_id` int(11) NOT NULL,
  `total_power_wh` int(11) NOT NULL,
  `ai_response` text NOT NULL,
  `tanggal_analisis` datetime DEFAULT current_timestamp(),
  `total_power_kwh` float DEFAULT NULL,
  `estimated_cost_rp` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `hasil_analisis`
--

INSERT INTO `hasil_analisis` (`id_analisis`, `user_id`, `riwayat_id`, `total_power_wh`, `ai_response`, `tanggal_analisis`, `total_power_kwh`, `estimated_cost_rp`) VALUES
(31, 8, 137, 615, 'Data Perangkat:\n vcxcvxc (Entertainment): 18.45 kWh\n\nTotal daya listrik simultan yang terpakai adalah 123 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 777 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah vcxcvxc (Entertainment), dengan total 18.45 kWh.\n\nSaran penghematan:\n1.  Optimalkan penggunaan perangkat hiburan. Matikan saat tidak digunakan dan pertimbangkan TV LED yang lebih hemat energi.\n2.  Gunakan lampu LED yang lebih hemat energi.\n3.  Cabut pengisi daya (charger) dari stop kontak saat tidak digunakan. Meskipun tidak mengisi daya, mereka tetap mengonsumsi sedikit energi (phantom load).\n\nRekomendasi Perangkat:\n- TV LED modern dengan fitur hemat energi menawarkan konsumsi daya yang lebih rendah dibandingkan TV tabung atau LCD generasi lama. Pertimbangkan model dengan sertifikasi Energy Star.', '2025-06-08 13:47:58', 0.615, 'Rp. 24.944'),
(32, 8, 138, 336, 'Data Perangkat:\n wokee (Heating): 1.44 kWh\n kak (Kitchen): 3.72 kWh\n dakmczxi (Lighting): 2.25 kWh\n uadabjz (Health): 0.45 kWh\n\nTotal daya listrik simultan yang terpakai adalah 336.00 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 564.00 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah kak (Kitchen), dengan total 3.72 kWh.\n\nSaran penghematan:\n1.  Optimalkan penggunaan perangkat kak (Kitchen), pertimbangkan penggunaan alat yang lebih hemat energi atau mengurangi durasi pemakaian.\n2.  Maksimalkan pencahayaan alami pada siang hari untuk mengurangi penggunaan dakmczxi (Lighting). Gunakan lampu LED yang lebih hemat energi.\n3.  Pastikan wokee (Heating) digunakan hanya saat diperlukan. Atur suhu ruangan dengan bijak dan pertimbangkan penggunaan timer.\n\nRekomendasi Perangkat:\n- Pertimbangkan untuk mengganti kak (Kitchen) dengan perangkat yang lebih efisien, misalnya rice cooker atau blender modern yang memiliki fitur hemat energi.', '2025-06-08 13:54:22', 0.336, 'Rp. 13.628'),
(34, 8, 143, 2520, 'Data Perangkat:\n Lampu (total): 5.4 kWh\n\nTotal daya listrik simultan yang terpakai adalah 2520 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda melebihi kapasitas.\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah perangkat lain selain data yang diberikan, dengan total kWh yang signifikan. Perlu dicatat bahwa konsumsi kulkas yang 24 jam lebih banyak bergantung pada efisiensi perangkat dan kebiasaan penggunaan, bukan semata durasi.\n\nSaran penghematan:\n1. Ganti lampu pijar dengan lampu LED yang lebih hemat energi, bisa hemat hingga 80% konsumsi energi.\n2. Cabut perangkat elektronik dari stop kontak saat tidak digunakan (phantom load).\n3. Pastikan pintu kulkas tertutup rapat dan hindari membuka terlalu sering untuk menjaga suhu stabil.\n\nRekomendasi Perangkat:\n- Mengganti lampu pijar dengan lampu LED Philips Smart Wi-Fi LED Bulb atau lampu LED merek lain dengan fitur smart.', '2025-06-08 14:28:02', 2.52, 'Rp. 102.211'),
(35, 8, 144, 2520, 'Data Perangkat:\n Lampu (total): 5.4 kWh\n\nTotal daya listrik simultan yang terpakai adalah 2520 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda melebihi kapasitas\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Lampu, dengan total 5.4 kWh.\n\nSaran penghematan:\n1. Ganti lampu dengan lampu LED yang jauh lebih hemat energi.\n2. Maksimalkan pencahayaan alami di siang hari untuk mengurangi penggunaan lampu.\n3. Gunakan sensor gerak atau timer untuk lampu di area yang jarang digunakan.\n\nRekomendasi Perangkat:\n- Ganti lampu pijar atau lampu neon dengan lampu LED Philips Smart Wi-Fi LED Bulb.', '2025-06-08 14:30:50', 2.52, 'Rp. 102.211'),
(36, 8, 145, 24, 'Data Perangkat:\n Entertainment: 0.72 kWh\n\nTotal daya listrik simultan yang terpakai adalah 12 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 888 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Entertainment, dengan total 0.72 kWh.\n\nSaran penghematan:\n1.  Matikan perangkat Entertainment saat tidak digunakan, jangan biarkan dalam mode standby.\n2.  Pertimbangkan menggunakan lampu LED hemat energi untuk penerangan.\n3.  Optimalkan pengaturan kecerahan layar TV dan perangkat lainnya untuk mengurangi konsumsi daya.\n\nRekomendasi Perangkat:\n- Untuk mengganti perangkat Entertainment anda bisa menggunakan Smart TV LED yang lebih modern karena mengkonsumsi daya yang lebih rendah dari TV tabung tradisional.', '2025-06-08 14:53:22', 0.024, 'Rp. 973'),
(37, 8, 146, 24, 'Data Perangkat:\n ssda (Entertainment): 0.72 kWh\n\nTotal daya listrik simultan yang terpakai adalah 12 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 888 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah ssda (Entertainment), dengan total 0.72 kWh.\n\nSaran penghematan:\n1.  Pastikan perangkat ssda (Entertainment) dimatikan sepenuhnya saat tidak digunakan. Hindari mode standby yang tetap mengonsumsi listrik.\n2.  Pertimbangkan menggunakan lampu LED yang lebih hemat energi jika perangkat ssda (Entertainment) menggunakan lampu.\n3.  Gunakan timer otomatis untuk mematikan perangkat ssda (Entertainment) setelah jangka waktu tertentu, terutama jika sering lupa mematikan.', '2025-06-08 14:55:04', 0.024, 'Rp. 973'),
(38, 8, 147, 24, 'Data Perangkat:\n dasda (Entertainment): 0.72 kWh\n\nTotal daya listrik simultan yang terpakai adalah 24.00 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 876 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah dasda (Entertainment), dengan total 0.72 kWh.\n\nSaran penghematan:\n1.  Matikan dasda (Entertainment) saat tidak digunakan.\n2.  Gunakan lampu LED yang lebih hemat energi sebagai alternatif.\n3.  Cabut pengisi daya perangkat elektronik dari stop kontak saat tidak digunakan.\n\nRekomendasi Perangkat:\n- Tidak ada rekomendasi penggantian perangkat karena konsumsi masih jauh di bawah daya terpasang.', '2025-06-08 14:55:50', 0.024, 'Rp. 973'),
(39, 8, 148, 24, 'Data Perangkat:\n dasda (Entertainment): 0.72 kWh\n\nTotal daya listrik simultan yang terpakai adalah 24.00 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 876 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah dasda (Entertainment), dengan total 0.72 kWh.\n\nSaran penghematan:\n1.  Matikan perangkat hiburan (dasda) saat tidak digunakan.\n2.  Pertimbangkan lampu LED hemat energi untuk mengurangi konsumsi.\n3.  Pastikan isolasi rumah baik untuk mengurangi kebutuhan pendinginan atau pemanasan.\n\nRekomendasi Perangkat:\n- Untuk dasda (Entertainment), pertimbangkan untuk mengganti dengan perangkat modern yang lebih efisien energi.', '2025-06-08 14:56:12', 0.024, 'Rp. 973'),
(40, 8, 149, 24, 'Data Perangkat:\n TV: 0.72 kWh\n\nTotal daya listrik simultan yang terpakai adalah 12 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 888 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah TV, dengan total 0.72 kWh.\n\nSaran penghematan:\n1.  Gunakan TV seperlunya dan matikan saat tidak ditonton.\n2.  Pertimbangkan TV LED yang lebih hemat energi dibandingkan model lama.\n3.  Manfaatkan fitur sleep timer pada TV agar mati secara otomatis.\n\nRekomendasi Perangkat:\n- Ganti TV dengan model LED yang lebih hemat energi. Pertimbangkan TV LED dengan fitur eco-mode atau sensor cahaya yang dapat menyesuaikan kecerahan layar secara otomatis, seperti Samsung Smart TV LED atau LG LED TV.', '2025-06-08 14:56:31', 0.024, 'Rp. 973'),
(41, 8, 150, 24, 'Data Perangkat:\n Entertainment: 0.72 kWh\n\nTotal daya listrik simultan yang terpakai adalah 12 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 888 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Entertainment, dengan total 0.72 kWh.\n\nSaran penghematan:\n1. Matikan perangkat Entertainment saat tidak digunakan, jangan biarkan dalam mode standby.\n2. Gunakan lampu LED untuk penerangan, yang jauh lebih hemat energi dibandingkan lampu pijar atau neon.\n3. Pertimbangkan untuk mengganti perangkat Entertainment yang sudah tua dengan model baru yang lebih hemat energi (berlabel Energy Star).\n\nRekomendasi Perangkat:\n- Tidak ada rekomendasi penggantian perangkat karena konsumsi daya masih jauh di bawah kapasitas daya terpasang bangunan.', '2025-06-08 14:57:02', 0.024, 'Rp. 973'),
(42, 8, 151, 21, 'Data Perangkat:\n Entertainment: 0.651 kWh\n\nTotal daya listrik simultan yang terpakai adalah 21 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 879 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Entertainment, dengan total 0.651 kWh.\n\nSaran penghematan:\n1.  Matikan perangkat Entertainment saat tidak digunakan, jangan biarkan dalam keadaan standby karena tetap mengonsumsi daya.\n2.  Manfaatkan fitur timer pada perangkat Entertainment untuk membatasi waktu penggunaan.\n3.  Pertimbangkan untuk mengganti perangkat Entertainment Anda dengan model yang lebih hemat energi, seperti yang memiliki sertifikasi Energy Star.\n\nRekomendasi Perangkat:\n- Pertimbangkan untuk mengganti perangkat Entertainment anda dengan TV LED yang lebih hemat energi. Saat ini, TV LED modern memiliki konsumsi daya yang lebih rendah dibandingkan dengan TV tabung atau LCD generasi lama. Cari model dengan sertifikasi Energy Star untuk memastikan efisiensi energi yang optimal.', '2025-06-08 14:57:19', 0.021, 'Rp. 851'),
(43, 8, 152, 21, 'Data Perangkat:\n Entertainment (21 Watt): 0.651 kWh\n\nTotal daya listrik simultan yang terpakai adalah 21 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 879 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Entertainment, dengan total 0.651 kWh.\n\nSaran penghematan:\n1.  Pastikan perangkat hiburan dimatikan sepenuhnya saat tidak digunakan, bukan hanya dalam mode standby.\n2.  Manfaatkan pencahayaan alami semaksimal mungkin untuk mengurangi penggunaan lampu, terutama saat menonton TV atau bermain game.\n3.  Pertimbangkan menggunakan perangkat hiburan yang lebih hemat energi (misalnya, TV LED dengan rating Energy Star).\n\nRekomendasi Perangkat:\n- Pertimbangkan mengganti TV tabung (CRT) lama dengan TV LED yang lebih modern dan hemat energi.', '2025-06-08 15:00:26', 0.021, 'Rp. 851'),
(44, 8, 153, 12, 'Data Perangkat:\n Entertainment: 0.36 kWh\n\nTotal daya listrik simultan yang terpakai adalah 12 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 888 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Entertainment, dengan total 0.36 kWh.\n\nSaran penghematan:\n1. Matikan perangkat elektronik saat tidak digunakan, jangan biarkan dalam mode standby.\n2. Manfaatkan pencahayaan alami semaksimal mungkin.\n3. Gunakan lampu LED yang lebih hemat energi dibandingkan lampu pijar atau neon.\n\nRekomendasi Perangkat:\n- Tidak ada.', '2025-06-08 15:06:25', 0.012, 'Rp. 486'),
(45, 8, 154, 120, 'Data Perangkat:\n Cooling: 3.6 kWh\n\nTotal daya listrik simultan yang terpakai adalah 120 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 780 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Cooling, dengan total 3.6 kWh.\n\nSaran penghematan:\n1.  Pastikan Cooling yang digunakan memiliki fitur hemat energi, seperti mode \"Eco\" atau \"Sleep\".\n2.  Optimalkan penggunaan Cooling. Gunakan hanya saat diperlukan dan atur suhu sesuai kebutuhan, hindari suhu terlalu rendah.\n3.  Pertimbangkan mengganti Cooling dengan model inverter yang lebih efisien energi.\n\nRekomendasi Perangkat:\n- Pertimbangkan mengganti Cooling dengan AC Split Inverter yang lebih efisien.', '2025-06-09 13:30:07', 0.12, 'Rp. 4.867'),
(46, 8, 155, 270, 'Data Perangkat:\n Laptop (Entertainment): 8.1 kWh\n\nTotal daya listrik simultan yang terpakai adalah 270.00 Watt.\nDengan daya terpasang bangunan 900 VA (sekitar 900 Watt), penggunaan listrik Anda masih memiliki sisa 630 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Laptop (Entertainment), dengan total 8.1 kWh.\n\nSaran penghematan:\n1.  Matikan laptop saat tidak digunakan. Kebiasaan sederhana ini akan mengurangi konsumsi listrik secara signifikan.\n2.  Optimalkan pengaturan daya laptop. Kurangi kecerahan layar dan aktifkan mode hemat daya.\n3.  Pertimbangkan penggunaan perangkat yang lebih hemat energi jika memungkinkan, terutama jika sering menggunakan laptop untuk tugas-tugas ringan.\n\nRekomendasi Perangkat:\n- Pertimbangkan laptop modern dengan sertifikasi hemat energi (misalnya, Energy Star) untuk mengurangi konsumsi listrik jangka panjang.', '2025-06-09 15:42:50', 0.27, 'Rp. 10.951'),
(47, 8, 156, 270, 'Data Perangkat:\n Laptop (Entertainment): 8.1 kWh\n\nTotal daya listrik simultan yang terpakai adalah 135 Watt.\nDengan daya terpasang bangunan 450 VA (sekitar 450 Watt), penggunaan listrik Anda masih memiliki sisa 315 Watt\n\nPerangkat paling boros (berdasarkan kWh bulanan) adalah Laptop (Entertainment), dengan total 8.1 kWh.\n\nSaran penghematan:\n1. Matikan laptop saat tidak digunakan, jangan biarkan dalam mode sleep.\n2. Aktifkan fitur hemat daya pada laptop.\n3. Pertimbangkan menggunakan laptop atau tablet yang lebih hemat energi untuk hiburan ringan.\n\nRekomendasi Perangkat:\n- Tidak ada perangkat yang melebihi daya terpasang bangunan.\n- Sebagai alternatif hiburan yang lebih hemat energi, pertimbangkan menggunakan tablet modern dengan konsumsi daya lebih rendah dibandingkan laptop, terutama jika aktivitas utama adalah menonton video atau browsing internet. Tablet modern umumnya memiliki daya sekitar 10-20 Watt.', '2025-06-09 15:44:21', 0.27, 'Rp. 3.361');

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `queue` varchar(255) NOT NULL,
  `payload` longtext NOT NULL,
  `attempts` tinyint(3) UNSIGNED NOT NULL,
  `reserved_at` int(10) UNSIGNED DEFAULT NULL,
  `available_at` int(10) UNSIGNED NOT NULL,
  `created_at` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `total_jobs` int(11) NOT NULL,
  `pending_jobs` int(11) NOT NULL,
  `failed_jobs` int(11) NOT NULL,
  `failed_job_ids` longtext NOT NULL,
  `options` mediumtext DEFAULT NULL,
  `cancelled_at` int(11) DEFAULT NULL,
  `created_at` int(11) NOT NULL,
  `finished_at` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `kategori`
--

CREATE TABLE `kategori` (
  `id` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `kategori`
--

INSERT INTO `kategori` (`id`, `nama_kategori`) VALUES
(4, 'Audio & Headphone'),
(5, 'Kamera & Aksesori Fotografi'),
(7, 'Konsol Game'),
(6, 'Peralatan Rumah Tangga Elektronik'),
(8, 'Perangkat Jaringan & Router'),
(1, 'Perangkat Komputer & Laptop'),
(2, 'Smartphone & Tablet'),
(3, 'TV & Home Entertainment');

-- --------------------------------------------------------

--
-- Table structure for table `merek`
--

CREATE TABLE `merek` (
  `id` int(11) NOT NULL,
  `nama_merek` varchar(100) NOT NULL,
  `negara_asal` varchar(50) DEFAULT NULL,
  `tahun_berdiri` int(4) DEFAULT NULL,
  `website` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `merek`
--

INSERT INTO `merek` (`id`, `nama_merek`, `negara_asal`, `tahun_berdiri`, `website`) VALUES
(1, 'Samsung', 'Korea Selatan', 1938, 'https://www.samsung.com'),
(2, 'Apple', 'Amerika Serikat', 1976, 'https://www.apple.com'),
(3, 'Sony', 'Jepang', 1946, 'https://www.sony.com'),
(4, 'LG', 'Korea Selatan', 1947, 'https://www.lg.com'),
(5, 'Panasonic', 'Jepang', 1918, 'https://www.panasonic.com'),
(6, 'Xiaomi', 'China', 2010, 'https://www.mi.com'),
(7, 'Huawei', 'China', 1987, 'https://www.huawei.com'),
(8, 'Oppo', 'China', 2004, 'https://www.oppo.com'),
(9, 'Vivo', 'China', 2009, 'https://www.vivo.com'),
(10, 'Lenovo', 'China', 1984, 'https://www.lenovo.com'),
(11, 'HP', 'Amerika Serikat', 1939, 'https://www.hp.com'),
(12, 'Dell', 'Amerika Serikat', 1984, 'https://www.dell.com'),
(13, 'Asus', 'Taiwan', 1989, 'https://www.asus.com'),
(14, 'Acer', 'Taiwan', 1976, 'https://www.acer.com'),
(15, 'Microsoft', 'Amerika Serikat', 1975, 'https://www.microsoft.com'),
(16, 'Philips', 'Belanda', 1891, 'https://www.philips.com'),
(17, 'Toshiba', 'Jepang', 1875, 'https://www.toshiba.com'),
(18, 'Sharp', 'Jepang', 1912, 'https://www.sharp.com'),
(19, 'Siemens', 'Jerman', 1847, 'https://www.siemens.com'),
(20, 'Hitachi', 'Jepang', 1910, 'https://www.hitachi.com'),
(21, 'Bosch', 'Jerman', 1886, 'https://www.bosch.com'),
(22, 'Canon', 'Jepang', 1937, 'https://www.canon.com'),
(23, 'Nikon', 'Jepang', 1917, 'https://www.nikon.com'),
(24, 'GoPro', 'Amerika Serikat', 2002, 'https://www.gopro.com'),
(25, 'JBL', 'Amerika Serikat', 1946, 'https://www.jbl.com'),
(26, 'Bose', 'Amerika Serikat', 1964, 'https://www.bose.com'),
(27, 'Harman Kardon', 'Amerika Serikat', 1953, 'https://www.harmankardon.com'),
(28, 'Intel', 'Amerika Serikat', 1968, 'https://www.intel.com'),
(29, 'AMD', 'Amerika Serikat', 1969, 'https://www.amd.com'),
(30, 'Nvidia', 'Amerika Serikat', 1993, 'https://www.nvidia.com'),
(31, 'Realme', 'China', 2018, 'https://www.realme.com'),
(32, 'Nothing', 'Inggris', 2020, 'https://nothing.tech'),
(33, 'OnePlus', 'China', 2013, 'https://www.oneplus.com'),
(34, 'Poco', 'China', 2018, 'https://www.poco.net'),
(35, 'Infinix', 'China', 2013, 'https://www.infinixmobility.com'),
(36, 'TCL', 'China', 1981, 'https://www.tcl.com'),
(37, 'Haier', 'China', 1984, 'https://www.haier.com'),
(38, 'Hisense', 'China', 1969, 'https://www.hisense.com'),
(39, 'BenQ', 'Taiwan', 1984, 'https://www.benq.com'),
(40, 'Epson', 'Jepang', 1942, 'https://www.epson.com'),
(41, 'Meizu', 'China', 2003, 'https://www.meizu.com'),
(42, 'Fairphone', 'Belanda', 2013, 'https://www.fairphone.com'),
(43, 'Vestel', 'Turki', 1984, 'https://www.vestel.com'),
(44, 'Vaio', 'Jepang', 2014, 'https://www.vaio.com'),
(45, 'Shuttle', 'Taiwan', 1983, 'https://www.shuttle.eu'),
(46, 'Archos', 'Prancis', 1988, 'https://www.archos.com'),
(47, 'Blackview', 'China', 2013, 'https://www.blackview.hk'),
(48, 'Teac', 'Jepang', 1953, 'https://www.teac.com'),
(49, 'Kobo', 'Kanada', 2009, 'https://www.kobo.com'),
(50, 'Polaroid', 'Amerika Serikat', 1937, 'https://www.polaroid.com'),
(51, 'Zopo', 'China', 2008, 'https://www.zopomobile.com'),
(52, 'Ulefone', 'China', 2006, 'https://www.ulefone.com'),
(53, 'Doogee', 'China', 2013, 'https://www.doogee.cc'),
(54, 'BLU', 'Amerika Serikat', 2009, 'https://www.bluproducts.com'),
(55, 'Wiko', 'Prancis', 2011, 'https://www.wikomobile.com'),
(56, 'Vertu', 'Inggris', 1998, 'https://www.vertu.com'),
(57, 'AGM', 'China', 2011, 'https://www.agmmobile.com'),
(58, 'UMiDIGI', 'China', 2012, 'https://www.umidigi.com'),
(59, 'Cubot', 'China', 2007, 'https://www.cubot.net'),
(60, 'Gionee', 'China', 2002, 'https://www.gionee.com'),
(61, 'Kazam', 'Inggris', 2013, NULL),
(62, 'Medion', 'Jerman', 1983, 'https://www.medion.com'),
(63, 'Elephone', 'China', 2006, 'https://www.elephone.hk'),
(64, 'Xolo', 'India', 2012, 'https://www.xolo.in'),
(65, 'TP-Link', 'China', 1996, 'https://www.tp-link.com'),
(66, 'Fujitsu', 'Jepang', 1935, 'https://www.fujitsu.com'),
(67, 'Razer', 'Amerika Serikat', 2005, 'https://www.razer.com'),
(68, 'Oukitel', 'China', 2007, 'https://www.oukitel.com'),
(69, 'MSI', 'Taiwan', 1986, 'https://www.msi.com'),
(70, 'ViewSonic', 'Amerika Serikat', 1987, 'https://www.viewsonic.com'),
(71, 'Gigabyte', 'Taiwan', 1986, 'https://www.gigabyte.com'),
(72, 'Zotac', 'Hong Kong', 2006, 'https://www.zotac.com'),
(73, 'Getac', 'Taiwan', 1989, 'https://www.getac.com'),
(74, 'EVGA', 'Amerika Serikat', 1999, 'https://www.evga.com'),
(75, 'LeEco', 'China', 2004, NULL),
(76, 'General Electric', 'Amerika Serikat', 1892, 'https://www.ge.com'),
(77, 'Braun', 'Jerman', 1921, 'https://www.braunhousehold.com'),
(78, 'Dyson', 'Inggris', 1991, 'https://www.dyson.com'),
(79, 'iRobot', 'Amerika Serikat', 1990, 'https://www.irobot.com'),
(80, 'Beko', 'Turki', 1955, 'https://www.beko.com'),
(81, 'Daewoo', 'Korea Selatan', 1967, 'https://www.daewoo.com'),
(82, 'Sanyo', 'Jepang', 1947, NULL),
(83, 'Thomson', 'Prancis', 1893, 'https://www.thomson.net'),
(84, 'Konka', 'China', 1980, 'https://www.konka.com'),
(85, 'Casio', 'Jepang', 1946, 'https://www.casio.com'),
(86, 'Olympus', 'Jepang', 1919, 'https://www.olympus.com'),
(87, 'Fujifilm', 'Jepang', 1934, 'https://www.fujifilm.com'),
(88, 'Pentax', 'Jepang', 1919, 'https://www.pentax.com'),
(89, 'Leica', 'Jerman', 1914, 'https://www.leica.com'),
(90, 'Nubia', 'China', 2012, 'https://www.nubia.com'),
(91, 'ZTE', 'China', 1985, 'https://www.zte.com.cn'),
(92, 'Aiwa', 'Jepang', 1951, 'https://www.aiwa.com'),
(93, 'Eizo', 'Jepang', 1968, 'https://www.eizo.com'),
(94, 'AOC', 'Taiwan', 1967, 'https://www.aoc.com'),
(95, 'iiyama', 'Jepang', 1973, 'https://www.iiyama.com'),
(96, 'Loewe', 'Jerman', 1923, 'https://www.loewe.tv'),
(97, 'Grundig', 'Jerman', 1930, 'https://www.grundig.com'),
(98, 'DeWalt', 'Amerika Serikat', 1924, 'https://www.dewalt.com'),
(99, 'Elekta', 'Swedia', 1972, 'https://www.elekta.com'),
(100, 'Blaupunkt', 'Jerman', 1923, 'https://www.blaupunkt.com'),
(101, 'NAD', 'Kanada', 1972, 'https://www.nadelectronics.com'),
(102, 'Marantz', 'Jepang', 1952, 'https://www.marantz.com'),
(103, 'McIntosh', 'Amerika Serikat', 1949, 'https://www.mcintoshlabs.com'),
(104, 'Denon', 'Jepang', 1910, 'https://www.denon.com'),
(105, 'Technics', 'Jepang', 1965, 'https://www.technics.com'),
(106, 'Sennheiser', 'Jerman', 1945, 'https://www.sennheiser.com'),
(107, 'Audio-Technica', 'Jepang', 1962, 'https://www.audio-technica.com'),
(108, 'AKG', 'Austria', 1947, 'https://www.akg.com'),
(109, 'Beyerdynamic', 'Jerman', 1924, 'https://www.beyerdynamic.com'),
(110, 'Pioneer', 'Jepang', 1938, 'https://www.pioneer.com'),
(111, 'Insignia', 'Amerika Serikat', 2004, 'https://www.insigniaproducts.com'),
(112, 'Dynex', 'Amerika Serikat', NULL, 'https://www.dynexproducts.com'),
(113, 'Croma', 'India', 2006, 'https://www.croma.com'),
(114, 'Venturer', 'Amerika Serikat', 1988, 'https://www.venturer.com'),
(115, 'Sceptre', 'Amerika Serikat', 1984, 'https://www.sceptre.com'),
(116, 'Element', 'Amerika Serikat', NULL, 'https://www.elementelectronics.com'),
(117, 'Westinghouse', 'Amerika Serikat', 1886, 'https://www.westinghouse.com'),
(118, 'RCA', 'Amerika Serikat', 1919, 'https://www.rca.com'),
(119, 'Cello', 'Inggris', 2001, 'https://www.celloelectronics.com'),
(120, 'Bush', 'Inggris', 1932, NULL),
(121, 'Alba', 'Inggris', 1917, NULL),
(122, 'Logic', 'Inggris', NULL, 'https://www.logikdigital.com'),
(123, 'Goodmans', 'Inggris', 1923, 'https://www.goodmans.co.uk'),
(124, 'In-lite', 'Belanda', 1991, 'https://www.in-lite.com'),
(125, 'Philips Hue', 'Belanda', 2012, 'https://www.philips-hue.com'),
(126, 'LIFX', 'Australia', 2012, 'https://www.lifx.com'),
(127, 'Nanoleaf', 'Kanada', 2012, 'https://nanoleaf.me'),
(128, 'Lutron', 'Amerika Serikat', 1961, 'https://www.lutron.com'),
(129, 'Legrand', 'Prancis', 1860, 'https://www.legrand.com'),
(130, 'Osram', 'Jerman', 1919, 'https://www.osram.com'),
(131, 'GE Lighting', 'Amerika Serikat', 1911, 'https://www.gelighting.com'),
(132, 'Cree Lighting', 'Amerika Serikat', 1987, 'https://www.creelighting.com'),
(133, 'Current by GE', 'Amerika Serikat', 2015, 'https://www.currentbyge.com'),
(134, 'Signify', 'Belanda', 2018, 'https://www.signify.com'),
(135, 'Feit Electric', 'Amerika Serikat', 1978, 'https://www.feit.com'),
(136, 'Satco', 'Amerika Serikat', 1966, 'https://www.satco.com'),
(137, 'WAC Lighting', 'Amerika Serikat', 1984, 'https://www.waclighting.com'),
(138, 'Kichler', 'Amerika Serikat', 1938, 'https://www.kichler.com'),
(139, 'Progress Lighting', 'Amerika Serikat', 1906, 'https://www.progresslighting.com'),
(140, 'Sylvania', 'Amerika Serikat', 1901, 'https://www.sylvania.com'),
(141, 'Maxlite', 'Amerika Serikat', 1993, 'https://www.maxlite.com'),
(142, 'Acuity Brands', 'Amerika Serikat', 2001, 'https://www.acuitybrands.com'),
(143, 'Cooper Lighting', 'Amerika Serikat', 1956, 'https://www.cooperlighting.com'),
(144, 'Lithonia Lighting', 'Amerika Serikat', 1946, 'https://www.lithonia.com'),
(145, 'Sengled', 'China', 2012, 'https://www.sengled.com'),
(146, 'Wiz', 'Hong Kong', 2015, 'https://www.wizconnected.com'),
(147, 'TP-Link Kasa', 'China', 2015, 'https://www.kasasmart.com'),
(148, 'Yeelight', 'China', 2012, 'https://www.yeelight.com'),
(149, 'Eve', 'Jerman', 2014, 'https://www.evehome.com'),
(150, 'Govee', 'China', 2017, 'https://www.govee.com'),
(151, 'Minka Group', 'Amerika Serikat', 1993, 'https://www.minkagroup.net'),
(152, 'Hunter', 'Amerika Serikat', 1886, 'https://www.hunterfan.com'),
(153, 'Leviton', 'Amerika Serikat', 1906, 'https://www.leviton.com'),
(154, 'Eaton', 'Irlandia', 1911, 'https://www.eaton.com'),
(155, 'Lightolier', 'Amerika Serikat', 1904, NULL),
(156, 'Sea Gull Lighting', 'Amerika Serikat', 1919, 'https://www.seagulllighting.com'),
(157, 'Juno Lighting', 'Amerika Serikat', 1976, 'https://www.junolighting.com'),
(158, 'Tech Lighting', 'Amerika Serikat', 1988, 'https://www.techlighting.com'),
(159, 'EGLO', 'Austria', 1969, 'https://www.eglo.com'),
(160, 'Artemide', 'Italia', 1960, 'https://www.artemide.com'),
(161, 'IKEA Trådfri', 'Swedia', 2016, 'https://www.ikea.com'),
(162, 'Ledger', 'Prancis', 2014, 'https://www.ledger.com'),
(163, 'Lightify', 'Jerman', 2014, NULL),
(164, 'Aurora', 'Inggris', 1999, 'https://www.auroralighting.com'),
(165, 'Paulmann', 'Jerman', 1982, 'https://www.paulmann.com'),
(166, 'Opple Lighting', 'China', 1996, 'https://www.opple.com'),
(167, 'Crompton', 'India', 1937, 'https://www.crompton.co.in'),
(168, 'Havells', 'India', 1958, 'https://www.havells.com'),
(169, 'Wipro Lighting', 'India', 1945, 'https://www.wiprolighting.com'),
(170, 'Syska LED', 'India', 2011, 'https://www.syska.in'),
(171, 'Brilliant Lighting', 'Australia', 1973, 'https://www.brilliantlighting.com.au'),
(172, 'Endon', 'Inggris', 1939, 'https://www.endon.co.uk'),
(173, 'Nordlux', 'Denmark', 1977, 'https://www.nordlux.com'),
(174, 'Elgato', 'Jerman', 1992, 'https://www.elgato.com'),
(175, 'Anker', 'China', 2011, 'https://www.anker.com'),
(176, 'Belkin', 'Amerika Serikat', 1983, 'https://www.belkin.com'),
(177, 'Logitech', 'Swiss', 1981, 'https://www.logitech.com'),
(178, 'Corsair', 'Amerika Serikat', 1994, 'https://www.corsair.com'),
(179, 'Thrustmaster', 'Prancis', 1990, 'https://www.thrustmaster.com'),
(180, 'Steelseries', 'Denmark', 2001, 'https://www.steelseries.com'),
(181, 'HyperX', 'Amerika Serikat', 2002, 'https://www.hyperxgaming.com'),
(182, 'Kingston', 'Amerika Serikat', 1987, 'https://www.kingston.com'),
(183, 'Western Digital', 'Amerika Serikat', 1970, 'https://www.westerndigital.com'),
(184, 'Seagate', 'Amerika Serikat', 1979, 'https://www.seagate.com'),
(185, 'Crucial', 'Amerika Serikat', 1996, 'https://www.crucial.com'),
(186, 'Netgear', 'Amerika Serikat', 1996, 'https://www.netgear.com'),
(187, 'D-Link', 'Taiwan', 1986, 'https://www.dlink.com'),
(188, 'Linksys', 'Amerika Serikat', 1988, 'https://www.linksys.com'),
(189, 'Ubiquiti', 'Amerika Serikat', 2005, 'https://www.ui.com'),
(190, 'ASRock', 'Taiwan', 2002, 'https://www.asrock.com'),
(191, 'Thermaltake', 'Taiwan', 1999, 'https://www.thermaltake.com'),
(192, 'NZXT', 'Amerika Serikat', 2004, 'https://www.nzxt.com'),
(193, 'be quiet!', 'Jerman', 2002, 'https://www.bequiet.com'),
(194, 'Cooler Master', 'Taiwan', 1992, 'https://www.coolermaster.com'),
(195, 'Fractal Design', 'Swedia', 2007, 'https://www.fractal-design.com'),
(196, 'Creative Technology', 'Singapura', 1981, 'https://www.creative.com'),
(197, 'Turtle Beach', 'Amerika Serikat', 1975, 'https://www.turtlebeach.com'),
(198, 'Focusrite', 'Inggris', 1985, 'https://www.focusrite.com'),
(199, 'PreSonus', 'Amerika Serikat', 1995, 'https://www.presonus.com'),
(200, 'Cosmos', 'Indonesia', 1975, 'https://www.cosmos.id');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `produk`
--

CREATE TABLE `produk` (
  `id` int(11) NOT NULL,
  `merek_id` int(11) DEFAULT NULL,
  `kategori_id` int(11) DEFAULT NULL,
  `nama_produk` varchar(100) NOT NULL,
  `model` varchar(50) DEFAULT NULL,
  `daya_watt` int(11) DEFAULT NULL,
  `kapasitas` varchar(50) DEFAULT NULL,
  `harga` decimal(15,2) DEFAULT NULL,
  `stok` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riwayat_perangkat`
--

CREATE TABLE `riwayat_perangkat` (
  `id` int(11) NOT NULL,
  `id_submit` varchar(36) NOT NULL,
  `user_id` int(11) NOT NULL,
  `Jenis_Pembayaran` varchar(255) NOT NULL,
  `Besar_Listrik` varchar(50) NOT NULL,
  `nama_perangkat` varchar(255) NOT NULL,
  `category` varchar(255) NOT NULL,
  `merek` varchar(255) NOT NULL,
  `daya` float NOT NULL,
  `durasi` float NOT NULL,
  `quantity` int(11) DEFAULT NULL,
  `daily_usage` decimal(10,2) DEFAULT NULL,
  `Weekly_Usage` float DEFAULT NULL,
  `Monthly_Usage` float DEFAULT NULL,
  `Monthly_cost` float DEFAULT NULL,
  `tanggal_input` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `riwayat_perangkat`
--

INSERT INTO `riwayat_perangkat` (`id`, `id_submit`, `user_id`, `Jenis_Pembayaran`, `Besar_Listrik`, `nama_perangkat`, `category`, `merek`, `daya`, `durasi`, `quantity`, `daily_usage`, `Weekly_Usage`, `Monthly_Usage`, `Monthly_cost`, `tanggal_input`) VALUES
(137, '49f47038-e239-4eec-820c-ef94545a2eca', 8, 'pascabayar', '0.90 VA', 'vcxcvxc', 'Entertainment', 'AMD', 123, 5, 1, 0.62, 4.305, 18.45, 26654.7, '2025-06-07'),
(138, '71270a34-1659-40a4-9dcf-a93ae2948a5b', 8, 'pascabayar', '0.90 VA', 'wokee', 'Heating', 'AGM', 12, 4, 1, 0.05, 0.336, 1.44, 2080.37, '2025-06-07'),
(139, '71270a34-1659-40a4-9dcf-a93ae2948a5b', 8, 'pascabayar', '0.90 VA', 'kak', 'Kitchen', 'AKG', 123, 1, 1, 0.12, 0.861, 3.69, 5330.94, '2025-06-08'),
(140, '71270a34-1659-40a4-9dcf-a93ae2948a5b', 8, 'pascabayar', '0.90 VA', 'dakmczxi', 'Lighting', 'Anker', 15, 5, 2, 0.15, 1.05, 4.5, 6501.15, '2025-06-08'),
(141, '71270a34-1659-40a4-9dcf-a93ae2948a5b', 8, 'pascabayar', '0.90 VA', 'uadabjz', 'Health', 'Beko', 15, 1, 1, 0.02, 0.105, 0.45, 650.115, '2025-06-09'),
(143, 'c0ea66e4-03d6-4e50-ac12-f41459348725', 8, 'pascabayar', '0.90 VA', 'Lampu', 'Lighting', 'In-lite', 15, 12, 14, 2.52, 17.64, 75.6, 109219, '2025-06-10'),
(144, '867d7ff1-9bf2-402c-97dd-2b2b65d8c72b', 8, 'pascabayar', '0.90 VA', 'Lampu', 'Lighting', 'In-lite', 15, 12, 14, 2.52, 17.64, 75.6, 109219, '2025-06-11'),
(145, '0fb24660-121b-40e0-97bc-b3bb8cd556bf', 8, 'pascabayar', '0.90 VA', 'ssda', 'Entertainment', 'Acuity Brands', 12, 2, 1, 0.02, 0.168, 0.72, 1040.18, '2025-06-08'),
(146, '2d7fcafa-c74a-4d8b-8b27-22e3ac2e5e73', 8, 'pascabayar', '0.90 VA', 'ssda', 'Entertainment', 'Acuity Brands', 12, 2, 1, 0.02, 0.168, 0.72, 1040.18, '2025-06-08'),
(147, '8634f959-e154-4053-81e4-e52eefbd3027', 8, 'pascabayar', '0.90 VA', 'dasda', 'Entertainment', 'Acuity Brands', 12, 2, 1, 0.02, 0.168, 0.72, 1040.18, '2025-06-09'),
(148, 'f5cada49-dca0-4ac1-9304-e67cd698c646', 8, 'pascabayar', '0.90 VA', 'dasda', 'Entertainment', 'Acuity Brands', 12, 2, 1, 0.02, 0.168, 0.72, 1040.18, '2025-06-12'),
(149, '3b951146-1e59-47c5-be8a-b5dcbb1b4cad', 8, 'pascabayar', '0.90 VA', 'dada', 'Entertainment', 'Acuity Brands', 12, 2, 1, 0.02, 0.168, 0.72, 1040.18, '2025-06-11'),
(150, '5c09f73f-376b-48ee-b74d-e252967a4907', 8, 'pascabayar', '0.90 VA', 'dada', 'Entertainment', 'Acuity Brands', 12, 2, 1, 0.02, 0.168, 0.72, 1040.18, '2025-06-11'),
(151, '411858df-22ae-48b5-9a90-67d532380d91', 8, 'pascabayar', '0.90 VA', 'sda', 'Entertainment', 'Acer', 21, 1, 1, 0.02, 0.147, 0.63, 910.161, '2025-06-12'),
(152, 'aa2a6294-9955-4e6a-9bed-e20d466b4eae', 8, 'pascabayar', '0.90 VA', 'sda', 'Entertainment', 'Acer', 21, 1, 1, 0.02, 0.147, 0.63, 910.161, '2025-06-11'),
(153, '758777cf-7623-4b90-9ed4-723f4ca97d99', 8, 'pascabayar', '0.90 VA', 'sdad', 'Entertainment', 'Acuity Brands', 12, 1, 1, 0.01, 0.084, 0.36, 520.092, '2025-06-10'),
(154, 'd1e54c8e-4e09-4357-82f5-c726fdcf88a7', 8, 'pascabayar', '0.90 VA', 'dasda', 'Cooling', 'Acuity Brands', 120, 1, 1, 0.12, 0.84, 3.6, 5200.92, '2025-06-09'),
(155, '463179bb-4c6d-4759-ad56-8e834f9d9b31', 8, 'pascabayar', '0.90 VA', 'Laptop', 'Entertainment', 'Acer', 135, 2, 1, 0.27, 1.89, 8.1, 11702.1, '2025-06-09'),
(156, 'd5fffec9-f3b9-4f69-8498-96f5d88fdee0', 8, 'pascabayar', '0.45 VA', 'Laptop', 'Entertainment', 'Acer', 135, 2, 1, 0.27, 1.89, 8.1, 11702.1, '2025-06-09');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) NOT NULL,
  `user_id` bigint(20) UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `user_agent` text DEFAULT NULL,
  `payload` longtext NOT NULL,
  `last_activity` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `sessions`
--

INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('IgDpGLufSgw4A1nGBgP68GWTuIkPiXDybdPrwhRg', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/134.0.0.0 Safari/537.36 OPR/119.0.0.0', 'YTo4OntzOjY6Il90b2tlbiI7czo0MDoiMGpURUtmMTZ3aGZ0R0JJTnZLdFpTVktraUdvSWc1NktmZjIxTDBZdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzA6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9yZWdpc3RlciI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NDoidXNlciI7YTozOntzOjI6ImlkIjtpOjg7czo1OiJlbWFpbCI7czoyNjoibGVvbmVsLmFndXN0YXZAYmludXMuYWMuaWQiO3M6NToidG9rZW4iO3M6MTcxOiJleUpoYkdjaU9pSklVekkxTmlJc0luUjVjQ0k2SWtwWFZDSjkuZXlKMWMyVnlYMmxrSWpvNExDSmxiV0ZwYkNJNklteGxiMjVsYkM1aFozVnpkR0YyUUdKcGJuVnpMbUZqTG1sa0lpd2laWGh3SWpveE56UTVOVE0wTnpjMGZRLmxWNFZfVHUzODlDQUJhT2k2Ym9zOWR1VlZ3elVBLTE1R1pfTVQtYmZWaWciO31zOjE1OiJkZXZpY2VfYW5hbHlzaXMiO2E6MTp7aTowO2E6MTI6e3M6NDoibmFtZSI7czo2OiJMYXB0b3AiO3M6NToiYnJhbmQiO3M6NDoiQWNlciI7czo4OiJjYXRlZ29yeSI7czoxMzoiRW50ZXJ0YWlubWVudCI7czo1OiJwb3dlciI7aToxMzU7czo4OiJkdXJhdGlvbiI7aToyO3M6ODoicXVhbnRpdHkiO2k6MTtzOjE2OiJqZW5pc19wZW1iYXlhcmFuIjtzOjEwOiJwYXNjYWJheWFyIjtzOjEzOiJiZXNhcl9saXN0cmlrIjtzOjc6IjAuNDUgVkEiO3M6MTc6ImRhaWx5X2NvbnN1bXB0aW9uIjtkOjAuMjc7czoxOToibW9udGhseV9jb25zdW1wdGlvbiI7ZDo4LjE7czoxMjoibW9udGhseV9jb3N0IjtkOjMzNjEuNTtzOjEwOiJwZXJjZW50YWdlIjtkOjEwMDt9fXM6MTc6InRvdGFsX2NvbnN1bXB0aW9uIjtkOjguMTAwMDAwMDAwMDAwMDAxO3M6MTA6InRvdGFsX2Nvc3QiO2Q6MzM2MS41MDAwMDAwMDAwMDA1O3M6MTE6ImFpX2FuYWx5c2lzIjtzOjkxNzoiRGF0YSBQZXJhbmdrYXQ6CiBMYXB0b3AgKEVudGVydGFpbm1lbnQpOiA4LjEga1doCgpUb3RhbCBkYXlhIGxpc3RyaWsgc2ltdWx0YW4geWFuZyB0ZXJwYWthaSBhZGFsYWggMTM1IFdhdHQuCkRlbmdhbiBkYXlhIHRlcnBhc2FuZyBiYW5ndW5hbiA0NTAgVkEgKHNla2l0YXIgNDUwIFdhdHQpLCBwZW5nZ3VuYWFuIGxpc3RyaWsgQW5kYSBtYXNpaCBtZW1pbGlraSBzaXNhIDMxNSBXYXR0CgpQZXJhbmdrYXQgcGFsaW5nIGJvcm9zIChiZXJkYXNhcmthbiBrV2ggYnVsYW5hbikgYWRhbGFoIExhcHRvcCAoRW50ZXJ0YWlubWVudCksIGRlbmdhbiB0b3RhbCA4LjEga1doLgoKU2FyYW4gcGVuZ2hlbWF0YW46CjEuIE1hdGlrYW4gbGFwdG9wIHNhYXQgdGlkYWsgZGlndW5ha2FuLCBqYW5nYW4gYmlhcmthbiBkYWxhbSBtb2RlIHNsZWVwLgoyLiBBa3RpZmthbiBmaXR1ciBoZW1hdCBkYXlhIHBhZGEgbGFwdG9wLgozLiBQZXJ0aW1iYW5na2FuIG1lbmdndW5ha2FuIGxhcHRvcCBhdGF1IHRhYmxldCB5YW5nIGxlYmloIGhlbWF0IGVuZXJnaSB1bnR1ayBoaWJ1cmFuIHJpbmdhbi4KClJla29tZW5kYXNpIFBlcmFuZ2thdDoKLSBUaWRhayBhZGEgcGVyYW5na2F0IHlhbmcgbWVsZWJpaGkgZGF5YSB0ZXJwYXNhbmcgYmFuZ3VuYW4uCi0gU2ViYWdhaSBhbHRlcm5hdGlmIGhpYnVyYW4geWFuZyBsZWJpaCBoZW1hdCBlbmVyZ2ksIHBlcnRpbWJhbmdrYW4gbWVuZ2d1bmFrYW4gdGFibGV0IG1vZGVybiBkZW5nYW4ga29uc3Vtc2kgZGF5YSBsZWJpaCByZW5kYWggZGliYW5kaW5na2FuIGxhcHRvcCwgdGVydXRhbWEgamlrYSBha3Rpdml0YXMgdXRhbWEgYWRhbGFoIG1lbm9udG9uIHZpZGVvIGF0YXUgYnJvd3NpbmcgaW50ZXJuZXQuIFRhYmxldCBtb2Rlcm4gdW11bW55YSBtZW1pbGlraSBkYXlhIHNla2l0YXIgMTAtMjAgV2F0dC4iO30=', 1749462473);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(20) UNSIGNED NOT NULL,
  `fullname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `fullname`, `username`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, '1', '1', '1@1', NULL, 'leonel', NULL, NULL, NULL),
(8, 'leonel MA', 'Leonel', 'leonel.agustav@binus.ac.id', NULL, '$2a$10$.7lBD1aGARi419B99pTepePJklpbLGxOhd3qSjwfWF2rhqX9vxVRS', NULL, NULL, NULL),
(10, 'LeonelMA', 'leon', 'leonel15072001@gmail.com', NULL, '$2a$10$sWyFlft8nEdnt5q/hIHMs..nlr3T2K/wYtnoIsDcm160PnsyPGBFi', NULL, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `hasil_analisis`
--
ALTER TABLE `hasil_analisis`
  ADD PRIMARY KEY (`id_analisis`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `riwayat_id` (`riwayat_id`);

--
-- Indexes for table `jobs`
--
ALTER TABLE `jobs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `jobs_queue_index` (`queue`);

--
-- Indexes for table `job_batches`
--
ALTER TABLE `job_batches`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `kategori`
--
ALTER TABLE `kategori`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_kategori` (`nama_kategori`);

--
-- Indexes for table `merek`
--
ALTER TABLE `merek`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nama_merek` (`nama_merek`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`),
  ADD KEY `merek_id` (`merek_id`),
  ADD KEY `kategori_id` (`kategori_id`);

--
-- Indexes for table `riwayat_perangkat`
--
ALTER TABLE `riwayat_perangkat`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `users_username_unique` (`username`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `hasil_analisis`
--
ALTER TABLE `hasil_analisis`
  MODIFY `id_analisis` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `kategori`
--
ALTER TABLE `kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `merek`
--
ALTER TABLE `merek`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=201;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `riwayat_perangkat`
--
ALTER TABLE `riwayat_perangkat`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=157;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `hasil_analisis`
--
ALTER TABLE `hasil_analisis`
  ADD CONSTRAINT `hasil_analisis_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `hasil_analisis_ibfk_2` FOREIGN KEY (`riwayat_id`) REFERENCES `riwayat_perangkat` (`id`);

--
-- Constraints for table `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`merek_id`) REFERENCES `merek` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `produk_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
