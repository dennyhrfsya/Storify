-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Mar 08, 2026 at 09:27 AM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_laravel_storify`
--

-- --------------------------------------------------------

--
-- Table structure for table `aset`
--

CREATE TABLE `aset` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(50) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `merk` varchar(150) NOT NULL,
  `nomor_seri` varchar(100) NOT NULL,
  `tanggal_pembelian` date DEFAULT NULL,
  `tanggal_garansi` date DEFAULT NULL,
  `kuantitas` int(11) NOT NULL DEFAULT 0,
  `harga` decimal(10,2) NOT NULL,
  `pt_pembeban` varchar(150) NOT NULL,
  `user_aset` varchar(150) NOT NULL,
  `lokasi` varchar(255) DEFAULT NULL,
  `kondisi` enum('baik','rusak') NOT NULL,
  `keterangan` text DEFAULT NULL,
  `status` enum('tersedia','dipinjam') NOT NULL,
  `bukti_tanda_terima` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `aset`
--

INSERT INTO `aset` (`id`, `kode_barang`, `nama_barang`, `kategori`, `merk`, `nomor_seri`, `tanggal_pembelian`, `tanggal_garansi`, `kuantitas`, `harga`, `pt_pembeban`, `user_aset`, `lokasi`, `kondisi`, `keterangan`, `status`, `bukti_tanda_terima`, `created_at`, `updated_at`) VALUES
(1, 'BRG001', 'Laptop Dell', 'Laptop', 'Dell', 'SN12345', '2024-01-15', '2027-03-03', 1, 15000000.00, 'PT Global Sekuriti Indonesia', 'Tarjo', 'Gudang A', 'rusak', 'Masih baru', 'tersedia', 'bukti_tanda_terima/dqeM2w9qHslznukAQKBBA8bk7uBPP0zXc8Lnyg2C.jpg', '2026-03-06 19:05:03', '2026-03-07 11:35:51'),
(2, 'BRG002', 'Macbook Pro M3', 'Laptop', 'Apple', '12345', '2026-03-08', '2027-03-10', 1, 15000000.00, 'PT Armindo Langgeng Sejahtera', 'Mr Ruditabuti', 'Gudang A', 'rusak', 'Oke', 'tersedia', 'bukti_tanda_terima/DcwicFW3w8ritw26Kxu24eOIrNnqO2pOyme5khYG.jpg', '2026-03-07 11:37:13', '2026-03-07 11:37:29'),
(3, 'BRG003', 'Asus TUF Gaming', 'Laptop', 'Asus', 'SN12345', '2026-03-08', '2026-03-11', 1, 12500000.00, 'PT Armindo Langgeng Sejahtera', 'Acong', 'Tebet', 'baik', 'Oke', 'tersedia', 'bukti_tanda_terima/n9eQcyT97m7Nq9zTySg48AtCFkEIolSd2ugu6keQ.jpg', '2026-03-07 13:29:43', '2026-03-07 13:30:12');

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
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2026_02_21_153240_add_role_to_table', 1),
(5, '2026_02_21_154837_add_two_factor_columns_to_users_table', 1),
(6, '2026_02_24_044718_create_aset_table', 1),
(7, '2026_03_03_040918_create_permissions_table', 1),
(8, '2026_03_05_055718_add_kuantitas_to_aset_table', 1),
(9, '2026_03_07_182931_create_stok_barang_table', 2),
(10, '2026_03_07_183039_create_transaksi_table', 2);

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
-- Table structure for table `permissions`
--

CREATE TABLE `permissions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `role` enum('admin','user') NOT NULL,
  `module` varchar(255) NOT NULL,
  `all` tinyint(1) NOT NULL DEFAULT 0,
  `tambah` tinyint(1) NOT NULL DEFAULT 0,
  `ubah` tinyint(1) NOT NULL DEFAULT 0,
  `hapus` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `permissions`
--

INSERT INTO `permissions` (`id`, `role`, `module`, `all`, `tambah`, `ubah`, `hapus`, `created_at`, `updated_at`) VALUES
(1, 'admin', 'User', 1, 1, 1, 1, '2026-03-06 19:05:03', '2026-03-07 22:13:40'),
(2, 'admin', 'Inventori', 1, 1, 1, 1, '2026-03-06 19:05:03', '2026-03-07 22:37:57'),
(3, 'user', 'User', 0, 0, 0, 0, '2026-03-06 19:05:03', '2026-03-06 19:06:17'),
(4, 'user', 'Inventori', 1, 0, 0, 0, '2026-03-06 19:05:03', '2026-03-06 19:05:03'),
(5, 'admin', 'Stok', 1, 1, 1, 1, '2026-03-07 12:26:28', '2026-03-07 13:44:36'),
(6, 'user', 'Stok', 1, 0, 0, 0, '2026-03-07 12:26:28', '2026-03-07 13:44:37');

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
('R6vsaf2cFOy8tWGkUPsZr3i09VMjdiq3przFA2h2', 1, '127.0.0.1', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/145.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiUk8xRGdXRUhONFppVkRxbW80STlVOGQzUkp5eklVMUtjQzRTNENBaSI7czo5OiJfcHJldmlvdXMiO2E6Mjp7czozOiJ1cmwiO3M6MjY6Imh0dHA6Ly8xMjcuMC4wLjE6ODAwMC9zdG9rIjtzOjU6InJvdXRlIjtzOjEwOiJzdG9rLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319czo1MDoibG9naW5fd2ViXzU5YmEzNmFkZGMyYjJmOTQwMTU4MGYwMTRjN2Y1OGVhNGUzMDk4OWQiO2k6MTt9', 1772958355);

-- --------------------------------------------------------

--
-- Table structure for table `stok_barang`
--

CREATE TABLE `stok_barang` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_barang` varchar(255) NOT NULL,
  `nama_barang` varchar(255) NOT NULL,
  `tanggal_pembelian` date NOT NULL,
  `pt_pembeban` varchar(255) NOT NULL,
  `satuan` varchar(255) NOT NULL,
  `harga_satuan` decimal(15,2) NOT NULL,
  `harga_total` decimal(15,2) NOT NULL,
  `stok_saat_ini` int(11) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `stok_barang`
--

INSERT INTO `stok_barang` (`id`, `kode_barang`, `nama_barang`, `tanggal_pembelian`, `pt_pembeban`, `satuan`, `harga_satuan`, `harga_total`, `stok_saat_ini`, `created_at`, `updated_at`) VALUES
(1, 'BRG-2026-001', 'Flashdisk 64GB', '2026-06-20', 'PT Global Sekuriti Indonesia', 'Pcs', 250000.00, 2500000.00, 10, '2026-03-07 12:17:43', '2026-03-08 01:20:15');

-- --------------------------------------------------------

--
-- Table structure for table `transaksi`
--

CREATE TABLE `transaksi` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `kode_transaksi` varchar(255) NOT NULL,
  `stok_barang_id` bigint(20) UNSIGNED NOT NULL,
  `nama_peminta` varchar(255) NOT NULL,
  `departemen` varchar(255) NOT NULL,
  `jumlah` int(11) NOT NULL,
  `status` enum('dipinjamkan','dibatalkan','diberikan') NOT NULL,
  `stok_snapshot` int(11) NOT NULL,
  `tanggal_transaksi` timestamp NOT NULL DEFAULT current_timestamp(),
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `transaksi`
--

INSERT INTO `transaksi` (`id`, `kode_transaksi`, `stok_barang_id`, `nama_peminta`, `departemen`, `jumlah`, `status`, `stok_snapshot`, `tanggal_transaksi`, `created_at`, `updated_at`) VALUES
(1, 'TRX/2026/03/001', 1, 'Agus Setiawan', 'IT Support', 2, 'dipinjamkan', 8, '2026-03-07 12:17:43', '2026-03-07 12:17:43', '2026-03-07 12:17:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `two_factor_secret` text DEFAULT NULL,
  `two_factor_recovery_codes` text DEFAULT NULL,
  `two_factor_confirmed_at` timestamp NULL DEFAULT NULL,
  `role` enum('admin','user') NOT NULL DEFAULT 'user',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `two_factor_secret`, `two_factor_recovery_codes`, `two_factor_confirmed_at`, `role`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'Tarjo', 'admin@gmail.com', NULL, '$2y$12$SYAGXR6dzn2zbq3KCjkI4O/ow4r.tHXkv0deWLIjDNy2voHdKcoyG', NULL, NULL, NULL, 'admin', NULL, '2026-03-06 19:05:03', '2026-03-06 19:05:03'),
(2, 'Rudi tabuti', 'ruditabuti@gmail.com', NULL, '$2y$12$dgpgrHuFX9O.sZPVHe.mAOEcO7DZTJtjrJ9Qy3.ntRVU6q/HYLbqu', NULL, NULL, NULL, 'user', NULL, '2026-03-06 19:06:05', '2026-03-06 19:06:05');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `aset`
--
ALTER TABLE `aset`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cache`
--
ALTER TABLE `cache`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_expiration_index` (`expiration`);

--
-- Indexes for table `cache_locks`
--
ALTER TABLE `cache_locks`
  ADD PRIMARY KEY (`key`),
  ADD KEY `cache_locks_expiration_index` (`expiration`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

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
-- Indexes for table `permissions`
--
ALTER TABLE `permissions`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `stok_barang`
--
ALTER TABLE `stok_barang`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `stok_barang_kode_barang_unique` (`kode_barang`);

--
-- Indexes for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `transaksi_kode_transaksi_unique` (`kode_transaksi`),
  ADD KEY `transaksi_stok_barang_id_foreign` (`stok_barang_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `aset`
--
ALTER TABLE `aset`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `permissions`
--
ALTER TABLE `permissions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `stok_barang`
--
ALTER TABLE `stok_barang`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `transaksi`
--
ALTER TABLE `transaksi`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `transaksi`
--
ALTER TABLE `transaksi`
  ADD CONSTRAINT `transaksi_stok_barang_id_foreign` FOREIGN KEY (`stok_barang_id`) REFERENCES `stok_barang` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
