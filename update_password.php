<?php
// update_password.php - File untuk mengupdate password user langsung

// Set up Laravel environment
require_once __DIR__.'/vendor/autoload.php';

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

// Mulai aplikasi Laravel
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

// Update password untuk user siswa1
$newPassword = Hash::make('12345678');

try {
    $user = User::where('username', 'siswa1')->first();

    if ($user) {
        $user->password = $newPassword;
        $user->save();

        echo "Password untuk user siswa1 berhasil diupdate.\n";
    } else {
        echo "User siswa1 tidak ditemukan di database.\n";

        // Coba insert user siswa1 jika tidak ditemukan
        try {
            User::create([
                'name' => 'Siswa Satu',
                'email' => 'siswa1@perpustakaan.test',
                'username' => 'siswa1',
                'password' => $newPassword,
                'role' => 'siswa',
            ]);
            echo "User siswa1 berhasil dibuat dengan password baru.\n";
        } catch (Exception $e) {
            echo "Gagal membuat user siswa1: " . $e->getMessage() . "\n";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}