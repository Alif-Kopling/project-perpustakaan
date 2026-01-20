✦ Aplikasi Perpustakaan Digital

  Aplikasi ini merupakan sistem manajemen perpustakaan digital yang dirancang untuk membantu pengelolaan buku, anggota,
  dan transaksi peminjaman secara efektif dan efisien. Dibangun dengan Laravel dan menggunakan antarmuka yang modern
  serta user-friendly.

  Fitur Utama

  📚 Manajemen Buku
   - Tambah, edit, dan hapus data buku
   - Impor data buku dari file CSV
   - Pencarian dan filter buku
   - Informasi lengkap buku (judul, penulis, penerbit, kategori, stok)

  👤 Manajemen Anggota
   - Tambah, edit, dan hapus data anggota
   - Impor data anggota dari file CSV
   - Pencarian dan filter anggota
   - Informasi lengkap anggota (nama, NIT, kelas, jurusan, username)

  🔄 Manajemen Transaksi
   - Peminjaman dan pengembalian buku
   - Pemilihan durasi peminjaman (1 minggu, 2 minggu, 3 minggu, 1 bulan)
   - Pelacakan status peminjaman
   - Identifikasi buku terlambat
   - Riwayat transaksi lengkap

  📊 Dashboard Interaktif
   - Statistik peminjaman harian, mingguan, dan bulanan
   - Grafik interaktif yang bisa di-update secara real-time
   - Informasi ringkas jumlah buku, anggota, dan transaksi aktif
   - Aktivitas terbaru di perpustakaan

  🔐 Sistem Otentikasi
   - Registrasi pengguna dengan informasi lengkap
   - Login dengan fitur "lihat password"
   - Lupa password dengan reset link
   - Otentikasi role (admin dan siswa)

  🎨 Tampilan Modern
   - Desain responsif yang cantik dan modern
   - Antarmuka yang intuitif dan mudah digunakan
   - Warna konsisten dengan tema perpustakaan
   - Pengalaman pengguna yang optimal

  Instalasi

  Prasyarat
   - PHP 8.0 atau lebih tinggi
   - Composer
   - MySQL atau database lain yang didukung
   - Web server (Apache/Nginx)

  Langkah-langkah Instalasi

   1. Clone repository ini:

   1 git clone https://github.com/nama-kamu/project-perpustakaan.git

   2. Masuk ke direktori proyek:

   1 cd project-perpustakaan

   3. Install dependensi:

   1 composer install

   4. Salin file .env.example ke .env:

   1 cp .env.example .env

   5. Generate application key:

   1 php artisan key:generate

   6. Konfigurasi database di file .env:

   1 DB_CONNECTION=mysql
   2 DB_HOST=127.0.0.1
   3 DB_PORT=3306
   4 DB_DATABASE=laravel
   5 DB_USERNAME=root
   6 DB_PASSWORD=

   7. Jalankan migrasi database:

   1 php artisan migrate

   8. Jalankan seeding jika diperlukan:

   1 php artisan db:seed

   9. Jalankan aplikasi:

   1 php artisan serve

  Aplikasi akan berjalan di http://localhost:8000

  Panduan Penggunaan

  Untuk Administrator

  Login
   1. Buka browser dan akses http://localhost:8000
   2. Klik "Login" di pojok kanan atas
   3. Masukkan username dan password admin
   4. Anda akan diarahkan ke dashboard admin

  Dashboard Admin
   - Melihat ringkasan jumlah buku, anggota, dan transaksi aktif
   - Melihat grafik statistik peminjaman
   - Melihat aktivitas terbaru
   - Akses cepat ke fitur penting

  Manajemen Buku
   1. Klik menu "Data Buku" di sidebar
   2. Lihat daftar semua buku
   3. Gunakan fitur pencarian untuk menemukan buku tertentu
   4. Tambah buku baru dengan klik tombol "Tambah Buku"
   5. Edit atau hapus buku dengan tombol aksi di setiap baris
   6. Impor data buku dari CSV dengan tombol "Import Buku"

  Manajemen Anggota
   1. Klik menu "Data Anggota" di sidebar
   2. Lihat daftar semua anggota
   3. Gunakan fitur pencarian untuk menemukan anggota tertentu
   4. Tambah anggota baru dengan klik tombol "Tambah Anggota"
   5. Edit atau hapus anggota dengan tombol aksi di setiap baris
   6. Impor data anggota dari CSV dengan tombol "Import Anggota"

  Manajemen Transaksi
   1. Klik menu "Transaksi" di sidebar
   2. Lihat daftar semua transaksi
   3. Tambah transaksi peminjaman baru
   4. Proses pengembalian buku dengan klik tombol "Kembalikan"
   5. Gunakan fitur pencarian untuk menemukan transaksi tertentu

  Untuk Siswa

  Registrasi
   1. Buka http://localhost:8000
   2. Klik "Daftar sekarang" di halaman login
   3. Isi formulir registrasi dengan data lengkap
   4. Pilih kelas dan jurusan dari dropdown yang tersedia
   5. Klik "Daftar Sekarang"

  Login
   1. Buka http://localhost:8000
   2. Klik "Login" di pojok kanan atas
   3. Masukkan username dan password
   4. Anda akan diarahkan ke dashboard siswa

  Dashboard Siswa
   - Melihat jumlah buku yang tersedia
   - Melihat jumlah buku yang sedang dipinjam
   - Melihat total transaksi
   - Melihat grafik statistik peminjaman pribadi
   - Melihat riwayat peminjaman terakhir

  Mencari dan Meminjam Buku
   1. Klik menu "Cari Buku" di sidebar
   2. Lihat daftar buku yang tersedia
   3. Gunakan fitur pencarian untuk menemukan buku tertentu
   4. Klik tombol "Pinjam Buku" di kartu buku yang ingin dipinjam
   5. Pilih durasi peminjaman (1 minggu, 2 minggu, 3 minggu, 1 bulan)
   6. Klik "Pinjam" untuk menyelesaikan proses

  Riwayat Peminjaman
   1. Klik menu "Riwayat Saya" di sidebar
   2. Lihat daftar semua transaksi peminjaman
   3. Kembalikan buku yang sedang dipinjam dengan klik tombol "Kembalikan"

  Fitur Spesifik

  📅 Durasi Peminjaman
   - Pilih durasi peminjaman saat membuat transaksi
   - Opsi: 1 minggu, 2 minggu, 3 minggu, atau 1 bulan
   - Sistem otomatis menghitung tanggal jatuh tempo
   - Identifikasi buku terlambat di dashboard

  📊 Statistik Interaktif
   - Grafik peminjaman harian, mingguan, dan bulanan
   - Tombol toggle untuk mengganti periode tampilan
   - Update real-time tanpa refresh halaman
   - Tersedia di dashboard admin dan siswa

  🔍 Pencarian Lanjutan
   - Pencarian buku berdasarkan judul, penulis, penerbit, atau kategori
   - Pencarian anggota berdasarkan nama, NIT, kelas, atau jurusan
   - Pencarian transaksi berdasarkan nama anggota atau judul buku
   - Filter dan sortir data yang fleksibel

  📥 Impor Data
   - Impor data buku dari file CSV
   - Impor data anggota dari file CSV
   - Template file CSV tersedia untuk kemudahan pengisian
   - Validasi data otomatis saat impor

  🔒 Keamanan
   - Otentikasi role-based (admin dan siswa)
   - Validasi input form yang ketat
   - Proteksi terhadap serangan umum
   - Session management yang aman

  Struktur Proyek

    1 project-perpustakaan/
    2 ├── app/
    3 │   ├── Http/
    4 │   │   ├── Controllers/
    5 │   │   │   ├── Admin/
    6 │   │   │   ├── Student/
    7 │   │   │   └── Auth/
    8 │   │   └── Middleware/
    9 │   ├── Models/
   10 │   └── ...
   11 ├── resources/
   12 │   ├── views/
   13 │   │   ├── admin/
   14 │   │   ├── student/
   15 │   │   ├── auth/
   16 │   │   └── layouts/
   17 │   └── ...
   18 ├── routes/
   19 │   └── web.php
   20 ├── database/
   21 │   ├── migrations/
   22 │   └── seeds/
   23 ├── public/
   24 ├── storage/
   25 ├── composer.json
   26 └── .env

  Kontribusi

  Kami menyambut baik kontribusi dari komunitas. Jika kamu ingin berkontribusi:

   1. Fork repository ini
   2. Buat branch fitur baru (git checkout -b fitur-baru)
   3. Commit perubahan kamu (git commit -m 'Tambah fitur baru')
   4. Push ke branch (git push origin fitur-baru)
   5. Buat pull request

  Lisensi

  Proyek ini dilisensikan di bawah MIT License - lihat file LICENSE (LICENSE) untuk detail selengkapnya.

  Dukungan

  Jika kamu menemukan masalah atau memiliki pertanyaan, silakan buat issue di repository ini. Kami akan berusaha
  membantu secepat mungkin.

  ---

  Dibuat dengan ❤️ oleh tim pengembang untuk membantu pengelolaan perpustakaan secara digital.
