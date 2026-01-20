# 📚 Aplikasi Perpustakaan Digital

Aplikasi Perpustakaan Digital adalah sistem manajemen perpustakaan berbasis web yang dibuat untuk memudahkan pengelolaan buku, anggota, dan transaksi peminjaman. Dibangun menggunakan **Laravel**, aplikasi ini fokus pada kemudahan penggunaan dengan tampilan yang rapi dan modern.

## ✨ Fitur Utama

* **Manajemen Buku**: tambah, edit, hapus, impor CSV, serta pencarian buku
* **Manajemen Anggota**: kelola data anggota dan impor CSV
* **Transaksi Peminjaman**: peminjaman, pengembalian, durasi fleksibel, dan riwayat
* **Dashboard Interaktif**: statistik peminjaman dan ringkasan data
* **Otentikasi**: login, registrasi, reset password, role admin & siswa
* **UI Responsif**: desain sederhana, konsisten, dan nyaman digunakan

## ⚙️ Instalasi Singkat

1. Clone repository

   ```bash
   git clone https://github.com/nama-kamu/project-perpustakaan.git
   cd project-perpustakaan
   ```
2. Install dependensi

   ```bash
   composer install
   ```
3. Setup environment

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```
4. Atur database di file `.env`, lalu jalankan:

   ```bash
   php artisan migrate --seed
   php artisan serve
   ```

Akses aplikasi di **[http://localhost:8000](http://localhost:8000)**

## 👥 Pengguna

* **Admin**: mengelola buku, anggota, transaksi, dan melihat statistik
* **Siswa**: mencari buku, meminjam, dan melihat riwayat peminjaman

## 📁 Struktur Singkat Proyek

```
project-perpustakaan/
├── app/Http/Controllers
├── resources/views
├── routes/web.php
├── database/
└── public/
```

## 🤝 Kontribusi

Kontribusi sangat terbuka. Silakan fork repository ini dan ajukan pull request jika ingin menambahkan fitur atau perbaikan.

## 📄 Lisensi

Proyek ini menggunakan **MIT License**.

---

Dibuat untuk mempermudah pengelolaan perpustakaan secara digital, tanpa ribet.
