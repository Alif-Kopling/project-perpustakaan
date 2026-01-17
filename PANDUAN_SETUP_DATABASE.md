# Panduan Setup Database untuk Aplikasi Perpustakaan

Ikuti langkah-langkah berikut untuk memastikan database Anda terkonfigurasi dengan benar sehingga login bisa berfungsi:

## Langkah 1: Pastikan Konfigurasi Database Benar
File `.env` Anda sudah terkonfigurasi dengan:
- DB_CONNECTION=mysql
- DB_HOST=127.0.0.1
- DB_PORT=3306
- DB_DATABASE=laravel
- DB_USERNAME=root
- DB_PASSWORD=(kosong)

## Langkah 2: Buat Database
1. Buka phpMyAdmin melalui Laragon
2. Buat database baru dengan nama `laravel`

## Langkah 3: Eksekusi Skema Database
1. Buka phpMyAdmin
2. Pilih database `laravel`
3. Klik tab "SQL"
4. Salin dan tempelkan isi dari file `setup_database.sql` yang ada di folder proyek
5. Klik "Go" untuk mengeksekusi

## Langkah 4: Generate Hash Password
1. Buka terminal/command prompt
2. Navigasi ke folder proyek: `cd C:\laragon\www\project-perpustakaan`
3. Jalankan: `php generate_hash.php`
4. Catat hasil hash yang ditampilkan

## Langkah 5: Update Password di Database
1. Buka phpMyAdmin
2. Pilih database `laravel`
3. Pilih tabel `users`
4. Ganti kolom `password` untuk setiap user dengan hash yang dihasilkan dari Langkah 4
   - Untuk user 'admin', 'siswa1', dan 'test'

Atau, Anda bisa menjalankan perintah SQL berikut di phpMyAdmin (ganti [HASH_HASIL_GENERATE] dengan hash yang dihasilkan dari generate_hash.php):

UPDATE `users` SET `password` = '[HASH_HASIL_GENERATE]' WHERE `username` IN ('admin', 'siswa1', 'test');

## Langkah 6: Coba Login
Setelah menyelesaikan semua langkah di atas, coba login ke aplikasi dengan:
- Username: admin atau siswa1
- Password: 12345678

## Alternatif: Gunakan Artisan (jika PHP sudah ada di PATH)
Jika Anda berhasil menambahkan PHP ke PATH, Anda bisa menjalankan perintah berikut di terminal:

1. `php artisan migrate:fresh --seed`
   Perintah ini akan membersihkan database lama dan membuat ulang dengan struktur dan data yang benar

2. Jika perintah di atas berhasil, Anda bisa langsung login dengan:
   - Username: admin atau siswa1
   - Password: 12345678

## Troubleshooting
Jika masih mengalami masalah:
1. Pastikan service MySQL di Laragon berjalan
2. Pastikan database `laravel` benar-benar dibuat
3. Pastikan tabel `users` berisi data pengguna
4. Pastikan password sudah di-hash dengan benar
5. Bersihkan cache browser Anda