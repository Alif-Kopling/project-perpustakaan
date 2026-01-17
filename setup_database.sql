-- Skrip SQL untuk membuat struktur database aplikasi perpustakaan

-- Tabel users
CREATE TABLE IF NOT EXISTS `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `role` enum('admin','siswa') COLLATE utf8mb4_unicode_ci DEFAULT 'siswa',
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel books
CREATE TABLE IF NOT EXISTS `books` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penulis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `penerbit` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kategori` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `stok` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel members
CREATE TABLE IF NOT EXISTS `members` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `nit` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `kelas` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `jurusan` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `members_username_unique` (`username`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabel transactions
CREATE TABLE IF NOT EXISTS `transactions` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `member_id` bigint unsigned NOT NULL,
  `book_id` bigint unsigned NOT NULL,
  `borrow_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('dipinjam','dikembalikan') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'dipinjam',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `transactions_member_id_foreign` (`member_id`),
  KEY `transactions_book_id_foreign` (`book_id`),
  CONSTRAINT `transactions_book_id_foreign` FOREIGN KEY (`book_id`) REFERENCES `books` (`id`) ON DELETE CASCADE,
  CONSTRAINT `transactions_member_id_foreign` FOREIGN KEY (`member_id`) REFERENCES `members` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Catatan: Untuk password '12345678', Anda perlu menghasilkan hash bcrypt terlebih dahulu
-- Anda bisa menjalankan file generate_hash.php untuk mendapatkan hash yang benar
-- Lalu ganti placeholder di bawah dengan hash yang benar

-- Contoh perintah untuk mendapatkan hash:
-- php generate_hash.php
-- Hasilnya akan seperti: $2y$10$rFzc5fwHs/E.qkTLBZqgEe0qz6h4BTP.Zl3wv0q0Xq0Xq0Xq0Xq0.

-- Setelah Anda mendapatkan hash yang benar, ganti placeholder berikut:
-- INSERT IGNORE INTO `users` (`name`, `email`, `username`, `password`, `role`, `created_at`, `updated_at`) VALUES
-- ('Administrator', 'admin@perpustakaan.test', 'admin', '[HASH_YANG_BENAR]', 'admin', NOW(), NOW()),
-- ('Siswa Satu', 'siswa1@perpustakaan.test', 'siswa1', '[HASH_YANG_BENAR]', 'siswa', NOW(), NOW()),
-- ('Test User', 'test@perpustakaan.test', 'test', '[HASH_YANG_BENAR]', 'admin', NOW(), NOW());

-- Sebagai alternatif, Anda bisa menggunakan perintah berikut di PHP untuk membuat hash:
-- password_hash('12345678', PASSWORD_BCRYPT)