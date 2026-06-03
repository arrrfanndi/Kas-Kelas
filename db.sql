-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               8.0.30 - MySQL Community Server - GPL
-- Server OS:                    Win64
-- HeidiSQL Version:             12.1.0.6537
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for db_kasqeu
CREATE DATABASE IF NOT EXISTS `db_kasqeu` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci */ /*!80016 DEFAULT ENCRYPTION='N' */;
USE `db_kasqeu`;

-- Dumping structure for table db_kasqeu.admin
CREATE TABLE IF NOT EXISTS `admin` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_whatsapp` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kasqeu.admin: ~1 rows (approximately)
INSERT INTO `admin` (`id`, `nama`, `username`, `password`, `no_whatsapp`) VALUES
	(1, 'Ruan Mei', 'bu_bendh', 'admin123', '8566010445');

-- Dumping structure for table db_kasqeu.pengeluaran_kas
CREATE TABLE IF NOT EXISTS `pengeluaran_kas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `kategori` varchar(50) NOT NULL,
  `nominal` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kasqeu.pengeluaran_kas: ~2 rows (approximately)
INSERT INTO `pengeluaran_kas` (`id`, `tanggal`, `keterangan`, `kategori`, `nominal`) VALUES
	(1, '2026-01-10', 'Beli Spidol & Penghapus Papan Tulis', 'Kebutuhan Kelas', 25000),
	(2, '2026-01-17', 'Fotokopi Bahan Tugas Kelompok PPKn', 'Fotokopi', 15000);

-- Dumping structure for table db_kasqeu.periode_kas
CREATE TABLE IF NOT EXISTS `periode_kas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `minggu_ke` int NOT NULL,
  `bulan` varchar(20) NOT NULL,
  `tahun` int NOT NULL,
  `tanggal_mulai` date NOT NULL,
  `tanggal_selesai` date NOT NULL,
  `deadline` date NOT NULL,
  `nominal` int NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kasqeu.periode_kas: ~3 rows (approximately)
INSERT INTO `periode_kas` (`id`, `minggu_ke`, `bulan`, `tahun`, `tanggal_mulai`, `tanggal_selesai`, `deadline`, `nominal`) VALUES
	(1, 1, 'Januari', 2026, '2026-01-05', '2026-01-11', '2026-01-09', 10000),
	(2, 2, 'Januari', 2026, '2026-01-12', '2026-01-18', '2026-01-16', 10000),
	(3, 3, 'Januari', 2026, '2026-01-19', '2026-01-25', '2026-01-23', 10000);

-- Dumping structure for table db_kasqeu.siswa
CREATE TABLE IF NOT EXISTS `siswa` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `no_whatsapp` varchar(20) NOT NULL,
  `status` enum('aktif','pindah') DEFAULT 'aktif',
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kasqeu.siswa: ~32 rows (approximately)
INSERT INTO `siswa` (`id`, `nama`, `username`, `password`, `no_whatsapp`, `status`) VALUES
	(1, 'Aditya Pratama', 'aditya_pratama', 'kasqeu123', '81234567890', 'aktif'),
	(2, 'Budi Santoso', 'budi_santoso', 'kasqeu123', '85711223344', 'aktif'),
	(3, 'Citra Lestari', 'citra_lestari', 'kasqeu123', '81988776655', 'aktif'),
	(4, 'Dian Wijaya', 'dian_wijaya', 'kasqeu123', '81399887766', 'aktif'),
	(5, 'Eko Prasetyo', 'eko_prasetyo', 'kasqeu123', '82155443322', 'aktif'),
	(6, 'Fajar Ramadhan', 'fajar_ramadhan', 'kasqeu123', '87811223344', 'aktif'),
	(7, 'Gita Permata', 'gita_permata', 'kasqeu123', '85233445566', 'aktif'),
	(8, 'Hendra Wijaya', 'hendra_wijaya', 'kasqeu123', '81244556677', 'aktif'),
	(9, 'Indah Cahyani', 'indah_cahyani', 'kasqeu123', '85677889900', 'aktif'),
	(10, 'Joko Susilo', 'joko_susilo', 'kasqeu123', '81311223344', 'aktif'),
	(11, 'Kartika Sari', 'kartika_sari', 'kasqeu123', '81955667788', 'aktif'),
	(12, 'Lukman Hakim', 'lukman_hakim', 'kasqeu123', '82266778899', 'aktif'),
	(13, 'Mega Utami', 'mega_utami', 'kasqeu123', '85788990011', 'aktif'),
	(14, 'Nurul Hidayah', 'nurul_hidayah', 'kasqeu123', '81299001122', 'aktif'),
	(15, 'Onny Wijaya', 'onny_wijaya', 'kasqeu123', '81322334455', 'aktif'),
	(16, 'Putri Amelia', 'putri_amelia', 'kasqeu123', '85244556677', 'aktif'),
	(17, 'Qori Amanda', 'qori_amanda', 'kasqeu123', '81966778899', 'aktif'),
	(18, 'Ruan Mei', 'ruan_mei', 'kasqeu123', '8256010445', 'aktif'),
	(19, 'Siti Aminah', 'siti_aminah', 'kasqeu123', '85688990011', 'aktif'),
	(20, 'Taufik Hidayat', 'taufik_hidayat', 'kasqeu123', '81211223344', 'aktif'),
	(21, 'Utari Putri', 'utari_putri', 'kasqeu123', '81355667788', 'aktif'),
	(22, 'Vina Wati', 'vina_wati', 'kasqeu123', '85766778899', 'aktif'),
	(23, 'Wahyu Hidayat', 'wahyu_hidayat', 'kasqeu123', '82277889900', 'aktif'),
	(24, 'Xena Allya', 'xena_allya', 'kasqeu123', '81988990011', 'aktif'),
	(25, 'Yoga Pratama', 'yoga_pratama', 'kasqeu123', '81222334455', 'aktif'),
	(26, 'Zaki Mubarak', 'zaki_mubarak', 'kasqeu123', '81344556677', 'aktif'),
	(27, 'Ahmad Fauzi', 'ahmad_fauzi', 'kasqeu123', '85266778899', 'aktif'),
	(28, 'Bayu Segara', 'bayu_segara', 'kasqeu123', '81977889900', 'aktif'),
	(29, 'Dewi Lestari', 'dewi_lestari', 'kasqeu123', '82188990011', 'aktif'),
	(30, 'Farhan Mifta', 'farhan_mifta', 'kasqeu123', '85611223344', 'aktif'),
	(31, 'Gilang Permana', 'gilang_permana', 'kasqeu123', '81255667788', 'aktif'),
	(32, 'Hany Safitri', 'hany_safitri', 'kasqeu123', '81366778899', 'aktif');

-- Dumping structure for table db_kasqeu.tagihan_kas
CREATE TABLE IF NOT EXISTS `tagihan_kas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `siswa_id` int NOT NULL,
  `periode_kas_id` int NOT NULL,
  `status` enum('belum','lunas') DEFAULT 'belum',
  `tanggal_bayar` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `siswa_id` (`siswa_id`),
  KEY `periode_kas_id` (`periode_kas_id`),
  CONSTRAINT `tagihan_kas_ibfk_1` FOREIGN KEY (`siswa_id`) REFERENCES `siswa` (`id`) ON DELETE RESTRICT,
  CONSTRAINT `tagihan_kas_ibfk_2` FOREIGN KEY (`periode_kas_id`) REFERENCES `periode_kas` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- Dumping data for table db_kasqeu.tagihan_kas: ~0 rows (approximately)
INSERT INTO `tagihan_kas` (`id`, `siswa_id`, `periode_kas_id`, `status`, `tanggal_bayar`) VALUES
	(1, 1, 1, 'lunas', '2026-01-06 08:30:00'),
	(2, 2, 1, 'lunas', '2026-01-07 10:15:00'),
	(3, 3, 1, 'lunas', '2026-01-06 14:20:00'),
	(4, 4, 1, 'belum', NULL),
	(5, 5, 1, 'lunas', '2026-01-08 09:00:00'),
	(6, 1, 2, 'lunas', '2026-01-13 09:11:00'),
	(7, 2, 2, 'lunas', '2026-01-14 11:00:00'),
	(8, 3, 2, 'belum', NULL),
	(9, 4, 2, 'belum', NULL),
	(10, 1, 3, 'belum', NULL),
	(11, 2, 3, 'belum', NULL),
	(12, 3, 3, 'belum', NULL),
	(13, 4, 3, 'belum', NULL);

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
