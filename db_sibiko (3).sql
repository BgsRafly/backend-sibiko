-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jan 03, 2026 at 08:14 AM
-- Server version: 9.4.0
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_sibiko`
--

-- --------------------------------------------------------

--
-- Table structure for table `ajuan`
--

CREATE TABLE `ajuan` (
  `id_ajuan` int NOT NULL,
  `nim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_handler` int DEFAULT NULL,
  `judul_konseling` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `deskripsi_masalah` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `jenis_layanan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `tanggal_pengajuan` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `tanggal_jadwal` datetime DEFAULT NULL,
  `status` enum('pending','terkirim','reschedule','disetujui') NOT NULL DEFAULT 'pending',
  `catatan_sesi` text,
  `tingkat_penanganan` enum('Prodi','Fakultas','Universitas') NOT NULL DEFAULT 'Prodi',
  `alasan_penolakan` text,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ajuan`
--

INSERT INTO `ajuan` (`id_ajuan`, `nim`, `id_handler`, `judul_konseling`, `deskripsi_masalah`, `jenis_layanan`, `tanggal_pengajuan`, `tanggal_jadwal`, `status`, `catatan_sesi`, `tingkat_penanganan`, `alasan_penolakan`, `created_at`, `updated_at`) VALUES
(5, '2408561062', 1, 'Konsultasi Masalah Belajar', 'Saya merasa sulit fokus saat kuliah daring.', 'Konseling Individu', '2026-01-03 06:47:09', '2026-01-20 10:00:00', 'disetujui', 'Masalah mahasiswa cukup kompleks dan di luar wewenang prodi, memerlukan kebijakan tingkat fakultas.', 'Fakultas', NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cache`
--

CREATE TABLE `cache` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cache`
--

INSERT INTO `cache` (`key`, `value`, `expiration`) VALUES
('laravel-cache-1fd8e4cfeb25c473c174cced2fcfdfb7', 'i:1;', 1767418663),
('laravel-cache-1fd8e4cfeb25c473c174cced2fcfdfb7:timer', 'i:1767418663;', 1767418663),
('laravel-cache-830b3b63aeb7c393f1a75d0894c14921', 'i:1;', 1766411908),
('laravel-cache-830b3b63aeb7c393f1a75d0894c14921:timer', 'i:1766411908;', 1766411908),
('laravel-cache-86661923a619c56d32390f6520b52426', 'i:1;', 1767425264),
('laravel-cache-86661923a619c56d32390f6520b52426:timer', 'i:1767425264;', 1767425264),
('laravel-cache-980b599806087df48b1a19d733ead185', 'i:1;', 1767427833),
('laravel-cache-980b599806087df48b1a19d733ead185:timer', 'i:1767427833;', 1767427833),
('laravel-cache-a75f3f172bfb296f2e10cbfc6dfc1883', 'i:1;', 1767426267),
('laravel-cache-a75f3f172bfb296f2e10cbfc6dfc1883:timer', 'i:1767426267;', 1767426267),
('laravel-cache-dcdbda746c5c7af82096edb6e1697205', 'i:2;', 1767422888),
('laravel-cache-dcdbda746c5c7af82096edb6e1697205:timer', 'i:1767422888;', 1767422888),
('laravel-cache-ddb1b9ec7844ef9cfda4a92d9babf754', 'i:1;', 1767425008),
('laravel-cache-ddb1b9ec7844ef9cfda4a92d9babf754:timer', 'i:1767425008;', 1767425008);

-- --------------------------------------------------------

--
-- Table structure for table `cache_locks`
--

CREATE TABLE `cache_locks` (
  `key` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `owner` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `expiration` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `queue` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `attempts` tinyint UNSIGNED NOT NULL,
  `reserved_at` int UNSIGNED DEFAULT NULL,
  `available_at` int UNSIGNED NOT NULL,
  `created_at` int UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `job_batches`
--

CREATE TABLE `job_batches` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `total_jobs` int NOT NULL,
  `pending_jobs` int NOT NULL,
  `failed_jobs` int NOT NULL,
  `failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `options` mediumtext COLLATE utf8mb4_unicode_ci,
  `cancelled_at` int DEFAULT NULL,
  `created_at` int NOT NULL,
  `finished_at` int DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `mahasiswa`
--

CREATE TABLE `mahasiswa` (
  `nim` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `id_dosen_pa` bigint UNSIGNED DEFAULT NULL,
  `nama_lengkap` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `prodi` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `no_hp` varchar(15) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `mahasiswa`
--

INSERT INTO `mahasiswa` (`nim`, `id_user`, `id_dosen_pa`, `nama_lengkap`, `prodi`, `email`, `no_hp`, `created_at`, `updated_at`) VALUES
('2408561062', 18, 1, 'Bagus Rafly', 'Informatika', 'rafly@student.unud.ac.id', '08123345453', '2026-01-02 21:50:50', '2026-01-02 21:50:50');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_12_15_145853_create_personal_access_tokens_table', 1),
(5, '2025_12_16_012253_create_mahasiswa_table', 2),
(6, '2026_01_03_041127_create_staff_table', 3),
(7, '2026_01_03_052409_create_staff_table', 4);

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `personal_access_tokens`
--

INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(1, 'App\\Models\\User', 9, 'mahasiswa-token', 'be15754017501bbb69d4abb363df9780ec946a960df0770274cb7c0617983072', '[\"*\"]', NULL, NULL, '2025-12-22 05:55:17', '2025-12-22 05:55:17'),
(3, 'App\\Models\\User', 9, 'auth-token', '12812d3dc2d14674dbb3fac9c7951d157b76de0b850b6b6f3e5272b54f685188', '[\"*\"]', NULL, NULL, '2025-12-22 05:59:29', '2025-12-22 05:59:29'),
(4, 'App\\Models\\User', 9, 'auth-token', 'f6a7108e19f4c82803c315f73048bb9ffd92307897643443dad309fdf01361c2', '[\"*\"]', NULL, NULL, '2025-12-22 06:10:52', '2025-12-22 06:10:52'),
(5, 'App\\Models\\User', 10, 'auth-token', '144e28d8fd473f66b1bc5877838c6cf8d5373cbac8ff70816e862979904f4235', '[\"*\"]', NULL, NULL, '2025-12-22 06:12:12', '2025-12-22 06:12:12'),
(6, 'App\\Models\\User', 11, 'auth-token', '25d8cf43765bf30658b58787271add447b03a5220bdadea5fa757c5003e21cac', '[\"*\"]', NULL, NULL, '2025-12-22 15:36:34', '2025-12-22 15:36:34'),
(8, 'App\\Models\\User', 12, 'auth-token', '2dccbed082a2ad731099433cbb6c94936a8a95b1579ab14873cd0cb1bcda18e2', '[\"*\"]', NULL, NULL, '2025-12-28 10:28:42', '2025-12-28 10:28:42'),
(9, 'App\\Models\\User', 12, 'auth-token', '0a8ef8a19897d7658d1909796257d5f9f1e60616f2dc3bc0459b431df1539dd7', '[\"*\"]', '2026-01-02 21:36:43', NULL, '2025-12-28 10:33:51', '2026-01-02 21:36:43'),
(10, 'App\\Models\\User', 15, 'auth-token', 'e13b18f8b6a789ccbfd26802c6747d87e0acf498da0130232a58001ca0407437', '[\"*\"]', NULL, NULL, '2026-01-02 21:19:10', '2026-01-02 21:19:10'),
(11, 'App\\Models\\User', 15, 'auth-token', '1f5ff0b195b7a6448269b2bb61e189ab6b83b1d78d5cff5edf405757ec469360', '[\"*\"]', NULL, NULL, '2026-01-02 21:26:35', '2026-01-02 21:26:35'),
(12, 'App\\Models\\User', 12, 'auth-token', '1f0ebdf961d307680cdf5051a5c453cbaa183f0f05254985cf3e33401287ab22', '[\"*\"]', NULL, NULL, '2026-01-02 21:27:48', '2026-01-02 21:27:48'),
(13, 'App\\Models\\User', 15, 'auth-token', '8477b45b2a751160e8e2bea9037cb16387b1648ffb078b4965c4f40016545db0', '[\"*\"]', NULL, NULL, '2026-01-02 21:30:19', '2026-01-02 21:30:19'),
(14, 'App\\Models\\User', 18, 'auth-token', '9dcd96f1d8826dd456dd60e661dd13322f35ea825f5445c4de66229f1f4d3af3', '[\"*\"]', NULL, NULL, '2026-01-02 21:52:31', '2026-01-02 21:52:31'),
(15, 'App\\Models\\User', 15, 'auth-token', '9dda96caaa3d3732e645df85eb6674246aad8e3afdeda955b5dc5306b13a0f93', '[\"*\"]', NULL, NULL, '2026-01-02 21:53:40', '2026-01-02 21:53:40'),
(16, 'App\\Models\\User', 18, 'auth-token', 'cb4c121dc1330e6a9efd5191666d853abd252e292ad7c8c306cd1cf32d69bac1', '[\"*\"]', '2026-01-02 22:47:20', NULL, '2026-01-02 22:16:06', '2026-01-02 22:47:20'),
(17, 'App\\Models\\User', 15, 'auth-token', '3ae7a9d0fe97285b74b6c5e2b0dbf8947f7f6bb542d7d1f623cf6a45ab2a24d7', '[\"*\"]', '2026-01-02 23:22:28', NULL, '2026-01-02 22:52:54', '2026-01-02 23:22:28'),
(18, 'App\\Models\\User', 15, 'auth-token', 'e372aa7954b037c5bca7093bdd73daf007005776fbc451665a07149ce203e546', '[\"*\"]', NULL, NULL, '2026-01-02 23:11:24', '2026-01-02 23:11:24'),
(19, 'App\\Models\\User', 22, 'auth-token', '0c5266e37dc837896a1f7ef45e44b3c9e1a20b50e472c0aeed9ae930951da38e', '[\"*\"]', '2026-01-02 23:26:44', NULL, '2026-01-02 23:14:14', '2026-01-02 23:26:44'),
(20, 'App\\Models\\User', 23, 'auth-token', 'f882a8cb4c3368a0c1676a1e5aa2e96ba3500676541b05157f1741ab9751c04f', '[\"*\"]', '2026-01-02 23:41:59', NULL, '2026-01-02 23:34:17', '2026-01-02 23:41:59'),
(21, 'App\\Models\\User', 23, 'auth-token', '6ba427e051c95f2a2cbfbeb276cf67cea7784b088df4385e6116180cbd255f37', '[\"*\"]', '2026-01-03 00:09:33', NULL, '2026-01-02 23:43:28', '2026-01-03 00:09:33');

-- --------------------------------------------------------

--
-- Table structure for table `sessions`
--

CREATE TABLE `sessions` (
  `id` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_id` bigint UNSIGNED DEFAULT NULL,
  `ip_address` varchar(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `user_agent` text COLLATE utf8mb4_unicode_ci,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `last_activity` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `staff`
--

CREATE TABLE `staff` (
  `id_staff` bigint UNSIGNED NOT NULL,
  `nip` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `id_user` bigint UNSIGNED NOT NULL,
  `nama_lengkap` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `jabatan` enum('Dosen PA','Konselor','Wakil Dekan 3','Admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `staff`
--

INSERT INTO `staff` (`id_staff`, `nip`, `id_user`, `nama_lengkap`, `jabatan`, `created_at`, `updated_at`) VALUES
(1, '1987654321', 15, 'Dr. Dosen Contoh', 'Dosen PA', '2026-01-03 05:29:20', '2026-01-03 05:29:20'),
(4, '197501012000031001', 22, 'Dr. Nama Wakil Dekan 3', 'Wakil Dekan 3', '2026-01-02 23:13:54', '2026-01-02 23:13:54'),
(5, '1234567890', 23, 'Administrator SI-BIKO', 'Admin', '2026-01-02 23:31:12', '2026-01-02 23:31:12'),
(6, '199005052024011001', 24, 'Budi Santoso, M.T.', 'Dosen PA', '2026-01-02 23:46:19', '2026-01-02 23:46:19');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint UNSIGNED NOT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('mahasiswa','dosen','konselor','wakil_dekan_3','admin') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
(15, 'dosen01', '$2y$12$mwuV2DvfbVmpGUfWR4SbT.P0pc50LXTHJkCygfTHN57NDKpZE.93S', 'dosen', NULL, NULL),
(18, '2408561062', '$2y$12$Vg7ms8g34U99IZgoaFU2e.dWAW1UP4wub8fh6A5p7pb3ZPSQg4xKe', 'mahasiswa', '2026-01-02 21:50:50', '2026-01-02 21:50:50'),
(22, 'wd3_fakultas', '$2y$12$uEHJWuUWigKpjSupgDmxPORbngZNXmuKdayBDqlYGIs3m0R8TYIqu', 'wakil_dekan_3', '2026-01-02 23:13:24', '2026-01-02 23:13:24'),
(23, 'admin_sibiko', '$2y$12$i9PWobgN2sHHmjWja/ivK.vNL4h7lhPP/Y4WuRuqN.W0OPoupKo1e', 'admin', '2026-01-02 23:31:05', '2026-01-02 23:31:05'),
(24, 'dosen_baru', '$2y$12$N4wPj44.YtR.hTo4zQA1CeTzIvljvNq9VVF5KVTHqPsxyL5.z9Tbm', 'dosen', '2026-01-02 23:46:19', '2026-01-02 23:46:19');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ajuan`
--
ALTER TABLE `ajuan`
  ADD PRIMARY KEY (`id_ajuan`),
  ADD KEY `fk_ajuan_mahasiswa` (`nim`);

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
-- Indexes for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD PRIMARY KEY (`nim`),
  ADD KEY `mahasiswa_id_user_foreign` (`id_user`),
  ADD KEY `fk_mahasiswa_dosen_pa` (`id_dosen_pa`);

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
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`),
  ADD KEY `personal_access_tokens_expires_at_index` (`expires_at`);

--
-- Indexes for table `sessions`
--
ALTER TABLE `sessions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `sessions_user_id_index` (`user_id`),
  ADD KEY `sessions_last_activity_index` (`last_activity`);

--
-- Indexes for table `staff`
--
ALTER TABLE `staff`
  ADD PRIMARY KEY (`id_staff`),
  ADD UNIQUE KEY `staff_nip_unique` (`nip`),
  ADD KEY `staff_id_user_foreign` (`id_user`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ajuan`
--
ALTER TABLE `ajuan`
  MODIFY `id_ajuan` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `jobs`
--
ALTER TABLE `jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `staff`
--
ALTER TABLE `staff`
  MODIFY `id_staff` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ajuan`
--
ALTER TABLE `ajuan`
  ADD CONSTRAINT `fk_ajuan_mahasiswa` FOREIGN KEY (`nim`) REFERENCES `mahasiswa` (`nim`) ON DELETE CASCADE;

--
-- Constraints for table `mahasiswa`
--
ALTER TABLE `mahasiswa`
  ADD CONSTRAINT `fk_mahasiswa_dosen_pa` FOREIGN KEY (`id_dosen_pa`) REFERENCES `staff` (`id_staff`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `mahasiswa_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `staff`
--
ALTER TABLE `staff`
  ADD CONSTRAINT `staff_id_user_foreign` FOREIGN KEY (`id_user`) REFERENCES `users` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
