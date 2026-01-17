<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Update or create admin user with password 12345678
        $admin = User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'email' => 'admin@perpustakaan.test',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );

        // Update or create student user with password 12345678
        $student = User::updateOrCreate(
            ['username' => 'siswa1'],
            [
                'name' => 'Siswa Satu',
                'email' => 'siswa1@perpustakaan.test',
                'password' => Hash::make('12345678'),
                'role' => 'siswa',
            ]
        );

        // Update or create test user with password 12345678
        $test = User::updateOrCreate(
            ['username' => 'test'],
            [
                'name' => 'Test User',
                'email' => 'test@perpustakaan.test',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
            ]
        );
    }
}
