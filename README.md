# 📚 Aplikasi Perpustakaan Laravel

Aplikasi **Perpustakaan Berbasis Web** yang dibangun menggunakan **Laravel 10/11**.  
Digunakan untuk mengelola **buku, anggota, dan transaksi peminjaman** dengan sistem role serta tampilan modern yang interaktif.

✨ Cocok untuk tugas sekolah, project pembelajaran, maupun pengembangan lanjutan.

---

## 🚀 Fitur Utama

### 🔐 Autentikasi & Manajemen User
- Login & logout berbasis session
- Multi-role authentication (**Admin & Siswa**)
- Middleware untuk pembatasan akses berdasarkan role

---

### 👨‍💼 Fitur Admin
- Dashboard admin
- Kelola data buku (**CRUD**)
- Kelola data anggota (**CRUD**)
- Kelola transaksi peminjaman & pengembalian
- Melihat seluruh histori transaksi
- Import data buku & anggota dari **file CSV**

---

### 👩‍🎓 Fitur Siswa
- Dashboard siswa
- Melihat daftar buku yang tersedia
- Melihat riwayat transaksi pribadi

---

## ✨ Fitur Tambahan
- 🎨 **Animasi Interaktif**
  - Hover effect pada tombol
  - Efek klik (ripple)
  - Transisi halus di seluruh UI
- 📂 **Import Data CSV**
  - Import buku & anggota dengan cepat
  - Disediakan **sample file CSV**

---

## 🛠️ Teknologi yang Digunakan

| Layer        | Teknologi |
|-------------|----------|
| Backend     | Laravel 10/11 |
| Database    | MySQL |
| Frontend   | Blade Template, Tailwind CSS |
| Arsitektur | MVC (Model-View-Controller) |

---

## 🗄️ Struktur Database
- `users` → Data login & role
- `books` → Data buku
- `members` → Data anggota
- `transactions` → Data peminjaman & pengembalian

---

## ⚙️ Instalasi

1. Clone repository
   ```bash
   git clone https://github.com/username/nama-repo.git

## ▶️ Cara Menggunakan Aplikasi (Sekali Jalan)

Pastikan sudah terinstall:
- PHP 8.1+
- Composer
- MySQL
- Git

Jalankan perintah berikut secara berurutan di terminal:

```bash
git clone https://github.com/username/nama-repo.git
cd nama-repo
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
