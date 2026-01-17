<?php
// reset_password.php - File untuk mereset password user

require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Mulai session untuk Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Cari user siswa1
$user = User::where('username', 'siswa1')->first();

if ($user) {
    // Ganti password
    $user->password = Hash::make('12345678');
    $user->save();

    echo "Password untuk user siswa1 berhasil diubah menjadi 12345678\n";
} else {
    // Buat user siswa1 jika tidak ditemukan
    User::create([
        'name' => 'Siswa Satu',
        'email' => 'siswa1@perpustakaan.test',
        'username' => 'siswa1',
        'password' => Hash::make('12345678'),
        'role' => 'siswa',
    ]);

    echo "User siswa1 tidak ditemukan, telah dibuat dengan password 12345678\n";
}